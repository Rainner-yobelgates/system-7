<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CashInResource\Pages;
use App\Filament\Resources\CashInResource\RelationManagers;
use App\Models\CashIn;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CashInResource extends Resource
{
    protected static ?string $model = CashIn::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('items')
                    ->label('Items')
                    ->placeholder('Masukkan barang')
                    ->required(),
                    TextInput::make('amount')
                    ->label('Amount')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->placeholder('Masukkan jumlah')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('items')
                ->searchable(),
                TextColumn::make('amount')
                ->money('IDR'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCashIns::route('/'),
            'create' => Pages\CreateCashIn::route('/create'),
            'edit' => Pages\EditCashIn::route('/{record}/edit'),
        ];
    }
}
