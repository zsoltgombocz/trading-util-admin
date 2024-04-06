<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClosedTradesResource\Pages;
use App\Filament\Resources\ClosedTradesResource\RelationManagers;
use App\Models\ClosedTrades;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class ClosedTradesResource extends Resource
{
    protected static ?string $model = ClosedTrades::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $pluralLabel = 'Kereskedés napló';
    protected static ?string $label = 'zárt nyitás';
    protected static ?string $recordTitleAttribute = 'stock';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()->columns(4)->schema([
                    Forms\Components\TextInput::make('stock')
                        ->label('Részvény')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(1),
                    Forms\Components\TextInput::make('open_positions')
                        ->label('Hány nyitásból volt meg')
                        ->required()
                        ->numeric()
                        ->columnSpan(1)
                        ->default(1),

                    Forms\Components\DatePicker::make('buy_occurred_at')
                        ->label('Benyílás dátuma')
                        ->displayFormat('Y.m.d')
                        ->native(false),

                    Forms\Components\DatePicker::make('sell_occurred_at')
                        ->label('Zárás dátuma')
                        ->native(false)
                        ->default(Carbon::now())
                        ->required()
                        ->displayFormat('Y.m.d'),
                ]),

                Forms\Components\Textarea::make('note')
                    ->label('Megjegyzés')
                    ->maxLength(65535)
                    ->rows(4)
                    ->columnSpanFull(),

                Forms\Components\Grid::make()
                    ->columns(6)
                    ->hidden(fn (ClosedTrades | null $record) => !$record)
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->columns(1)
                            ->columnStart(5)
                            ->label('Létrehozva:')
                            ->content(fn (ClosedTrades $record): string => $record->created_at->translatedFormat('Y. F. j.')),

                        Forms\Components\Placeholder::make('updated_at')
                            ->columns(1)
                            ->columnStart(6)
                            ->label('Frissítve:')
                            ->content(fn (ClosedTrades $record): string => $record->updated_at->translatedFormat('Y. F. j.'))
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        $monthList = ClosedTradesResource::monthList();
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('stock')->label('Részvény')
                    ->searchable(),
                Tables\Columns\TextColumn::make('active_days')->label('Nyitva volt')
                    ->numeric()
                    ->sortable()
                    ->suffix(' nap')
                    ->getStateUsing(fn (ClosedTrades $model) => $model->active_days)
                    ->badge(),
                Tables\Columns\TextColumn::make('open_positions')->label('Nyitások száma')
                    ->numeric()
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('buy_occurred_at')
                    ->label('Nyitás dátuma')
                    ->dateTime('Y.m.d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sell_occurred_at')
                    ->label('Zárás dátuma')
                    ->dateTime('Y.m.d')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('period')
                ->label('Időszak')
                ->form([
                    Forms\Components\Select::make('month')
                        ->label('Hónap')
                        ->options($monthList)
                        ->native(false)
                        ->afterStateUpdated(function (Forms\Set $set, $state) {
                            $periodStart = $state ? Carbon::now()->month($state)->day(1)->format('Y-m-d') : null;
                            $periodEnd = $state ? Carbon::now()->month($state)->endOfMonth()->format('Y-m-d') : null;
                            $set('period_start', $periodStart);
                            $set('period_end', $periodEnd);
                        }),

                    Forms\Components\DatePicker::make('period_start')
                        ->native(false)
                        ->displayFormat('Y.m.d')
                        ->label('Időszak kezdete'),

                    Forms\Components\DatePicker::make('period_end')
                        ->native(false)
                        ->displayFormat('Y.m.d')
                        ->label('Időszak vége'),

                    Forms\Components\Select::make('status')
                        ->label('Státusz')
                        ->native(false)
                        ->options([
                            'all' => 'Mind',
                            'opened' => 'Nyílt',
                            'closed' => 'Zárt'
                        ])
                        ->default('all')
                ])
                ->query(function (Builder $query, array $data): Builder {
                    $periodStart = $data['period_start'] ?? null;
                    $periodEnd = $data['period_end'] ?? null;
                    $status = $data['status'] ?? 'all';

                    if($periodStart)

                    // Filter by period_start and period_end
                    if ($status === 'opened' && $periodStart) {
                        $query->whereDate('buy_occurred_at', '>=', $periodStart);
                    }

                    if ($status === 'closed' && $periodEnd) {
                        $query->whereDate('sell_occurred_at', '<=', $periodEnd);
                    }

                    if($status === 'all') {
                        $query->whereDate('buy_occurred_at', '>=', $periodStart)
                            ->orWhereDate('sell_occurred_at', '<=', $periodEnd);
                    }

                    return $query;
                })
            ])->filtersFormWidth(MaxWidth::Medium)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageClosedTrades::route('/'),
        ];
    }

    /**
     * @return Collection<{month: int, name: string}>
     */
    public static function monthList(): Collection
    {
        return collect(range(1,12))
            ->mapWithKeys(fn ($month) => [$month => Carbon::create()->day(1)->month($month)->monthName]);
    }
}
