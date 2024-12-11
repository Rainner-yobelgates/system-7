<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CashOutResource\Pages;
use App\Filament\Resources\CashOutResource\RelationManagers;
use App\Models\CashOut;
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

class CashOutResource extends Resource
{
    protected static ?string $model = CashOut::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListCashOuts::route('/'),
            'create' => Pages\CreateCashOut::route('/create'),
            'edit' => Pages\EditCashOut::route('/{record}/edit'),
        ];
    }
}
