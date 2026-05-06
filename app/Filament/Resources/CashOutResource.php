<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\CashOutResource\Pages\ListCashOuts;
use App\Filament\Resources\CashOutResource\Pages\CreateCashOut;
use App\Filament\Resources\CashOutResource\Pages\EditCashOut;
use App\Models\CashOut;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CashOutResource extends Resource
{
    protected static ?string $model = CashOut::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-banknotes';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('expense')
                    ->label('Expense')
                    ->placeholder('Masukkan pengeluaran')
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
                TextColumn::make('expense')
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
            'index' => ListCashOuts::route('/'),
            'create' => CreateCashOut::route('/create'),
            'edit' => EditCashOut::route('/{record}/edit'),
        ];
    }
}
