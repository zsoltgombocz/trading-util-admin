<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClosedTradesResource\Pages;
use App\Filament\Resources\ClosedTradesResource\RelationManagers;
use App\Models\ClosedTrades;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class ClosedTradesResource extends Resource
{
    protected static ?string $model = ClosedTrades::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $pluralLabel = 'Kereskedés történet';
    protected static ?string $label = 'zárt nyitás';
    protected static ?string $recordTitleAttribute = 'stock';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()->columns(3)->schema([
                    Forms\Components\TextInput::make('stock')
                        ->label('Részvény')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(1),
                    Forms\Components\TextInput::make('active_days')
                        ->label('Hány napig volt nyitva')
                        ->helperText('Ha ez kivan töltve, akkor minden esetben ezt fogja a rendszer figyelembe venni.')
                        ->numeric()
                        ->columnSpan(1),
                    Forms\Components\TextInput::make('open_positions')
                        ->label('Hány nyitásból volt meg')
                        ->required()
                        ->numeric()
                        ->columnSpan(1)
                        ->default(1)
                ]),

                Forms\Components\DatePicker::make('buy_occurred_at')
                    ->label('Benyílás dátuma')
                    ->helperText(new HtmlString('Ha ez és a <b>Zárás dátuma</b> kivan töltve akkor automatikusan ebből lesz számolva a <b>Hány napig volt nyitva</b> érték.'))
                    ->displayFormat('Y.m.d')
                    ->native(false),
                Forms\Components\DatePicker::make('sell_occurred_at')
                    ->label('Zárás dátuma')
                    ->native(false)
                    ->default(Carbon::now())
                    ->required()
                    ->displayFormat('Y.m.d')
                    ->helperText(new HtmlString('Ha ez és a <b>Benyílás dátuma</b> kivan töltve akkor automatikusan ebből lesz számolva a <b>Hány napig volt nyitva</b> érték.')),

                Forms\Components\Textarea::make('note')
                    ->label('Megjegyzés')
                    ->maxLength(65535)
                    ->rows(4)
                    ->columnSpanFull(),

                Forms\Components\Grid::make()->columns(6)->schema([
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
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('stock')->label('Részvény')
                    ->searchable(),
                Tables\Columns\TextColumn::make('active_days')->label('Nyitva volt')
                    ->numeric()
                    ->sortable()
                    ->suffix(' nap')
                    ->getStateUsing(fn (ClosedTrades $model) => $model->activeDays())
                    ->badge(),
                Tables\Columns\TextColumn::make('open_positions')->label('Nyitások száma')
                    ->numeric()
                    ->sortable()
                    ->suffix(' nap')
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
                Tables\Filters\Filter::make('Időszak')
                    ->form([
                        Forms\Components\DatePicker::make('buy_occurred_at_form')
                            ->label('Nyitás dátuma')
                            ->native(false),
                        Forms\Components\DatePicker::make('sell_occurred_at_until')
                            ->label('Zárás dátuma')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['buy_occurred_at_form'],
                                fn(Builder $query, $date): Builder => $query->whereDate('buy_occurred_at', '>=', $date)->orWhere('buy_occurred_at', '=', null),
                            )
                            ->when(
                                $data['sell_occurred_at_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('sell_occurred_at', '<=', $date),
                            );
                    })
            ])
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
}
