<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\CashInResource\Pages\ListCashIns;
use App\Filament\Resources\CashInResource\Pages\CreateCashIn;
use App\Filament\Resources\CashInResource\Pages\EditCashIn;
use App\Models\CashIn;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CashInResource extends Resource
{
    protected static ?string $model = CashIn::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListCashIns::route('/'),
            'create' => CreateCashIn::route('/create'),
            'edit' => EditCashIn::route('/{record}/edit'),
        ];
    }
}
