<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Actions;
use Filament\Actions\Action;
use Filament\Schemas\Components\Section;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\TransactionResource\Pages\ListTransactions;
use App\Filament\Resources\TransactionResource\Pages\CreateTransaction;
use App\Filament\Resources\TransactionResource\Pages\ViewTransaction;
use App\Filament\Resources\TransactionResource\Pages\EditTransaction;
use App\Models\Transaction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 2;

    public static function infolist(Schema $schema): Schema
    {
        return $schema
        ->components([
            TextEntry::make('nama')
                ->label('Nama Pelanggan'),
            TextEntry::make('no_telp')
                ->label('No Telepon'),
            TextEntry::make('alamat')
            ->columnSpan('full'),
            TextEntry::make('merk_frame')
                ->label('Merk Frame'),
            TextEntry::make('jenis_lensa')
                ->label('Jenis Lensa'),
            TextEntry::make('harga_frame')
                ->label('Harga Frame')
                ->getStateUsing(function ($record) {
                    return number_format($record->harga_frame ?? 0, 2, ',', '.');
                }),
            TextEntry::make('harga_lensa')
                ->label('Harga Lensa')
                ->getStateUsing(function ($record) {
                    return number_format($record->harga_lensa ?? 0, 2, ',', '.');
                }),
            Group::make()
            ->columns(6)
            ->columnSpan('full')
            ->schema([
                TextEntry::make('right_eye_heading')
                ->label('Right Eye')
                ->getStateUsing(fn () => '')
                ->columnSpan('full'),
                TextEntry::make('r_sph')
                    ->label('SPH')
                    ->getStateUsing(fn($record) => $record->r_sph ?? '0'), 
                TextEntry::make('r_cyl')
                    ->label('CYL')
                    ->getStateUsing(fn($record) => $record->r_cyl ?? '0'), 
                TextEntry::make('r_axis')
                    ->label('AXIS')
                    ->getStateUsing(fn($record) => $record->r_axis ?? '0'), 
                TextEntry::make('r_add')
                    ->label('ADD')
                    ->getStateUsing(fn($record) => $record->r_add ?? '0'), 
                TextEntry::make('r_pd')
                    ->label('PD')
                    ->getStateUsing(fn($record) => $record->r_pd ?? '0'), 
            ]),
            Group::make()
            ->columns(6)
            ->columnSpan('full')
            ->schema([
                TextEntry::make('left_eye_heading')
                ->label('Left Eye')
                ->getStateUsing(fn () => '')
                ->columnSpan('full'),
                TextEntry::make('l_sph')
                    ->label('SPH')
                    ->getStateUsing(fn($record) => $record->l_sph ?? '0'), 
                TextEntry::make('l_cyl')
                    ->label('CYL')
                    ->getStateUsing(fn($record) => $record->l_cyl ?? '0'), 
                TextEntry::make('l_axis')
                    ->label('AXIS')
                    ->getStateUsing(fn($record) => $record->l_axis ?? '0'), 
                TextEntry::make('l_add')
                    ->label('ADD')
                    ->getStateUsing(fn($record) => $record->l_add ?? '0'), 
                TextEntry::make('l_pd')
                    ->label('PD')
                    ->getStateUsing(fn($record) => $record->l_pd ?? '0'), 
            ]),
            TextEntry::make('total')
                ->label('Total Harga')
                ->getStateUsing(function ($record) {
                    return number_format($record->total, 2, ',', '.');
                }),
            TextEntry::make('bayar')
                ->label('Jumlah Bayar/DP')
                ->getStateUsing(function ($record) {
                    return number_format($record->bayar, 2, ',', '.');
                }),
            TextEntry::make('kurang')
                ->label('Jumlah Kekurangan Pembayaran')
                ->getStateUsing(function ($record) {
                    return number_format($record->kurang, 2, ',', '.');
                }),
            TextEntry::make('status')
                ->label('Status'),
            TextEntry::make('note')
                ->columnSpan('full'),
            Actions::make([
                Action::make('pdf')
                    ->label('Print PDF')
                    ->icon('heroicon-m-document')
                    ->action(function ($record) {
                        return redirect()->route('generate.pdf', ['id' => $record->id]);
                    }),
                Action::make('wa')
                    ->label('Whatsapp')
                    ->icon('heroicon-o-phone-arrow-down-left')
                    ->color('success')
                    ->url(fn ($record) => 'https://wa.me/62' . ltrim(str_replace('-', '', $record->no_telp), '0')) // Redirect ke WhatsApp
                    ->openUrlInNewTab(), 
            ]),
        ]);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Pelanggan')
                    ->placeholder('Masukkan nama pelanggan')
                    ->required(),
                TextInput::make('no_telp')
                    ->label('No Telepon')
                    ->mask('9999-9999-99999')
                    ->rule('regex:/^[0-9\-]+$/')
                    ->placeholder('Masukkan nomor telepon')
                    ->required(),
                Textarea::make('alamat')
                    ->placeholder('Masukkan alamat lengkap')
                    ->rows(4)
                    ->columnSpan('full'),
                TextInput::make('merk_frame')
                    ->label('Merk Frame')
                    ->placeholder('Masukkan merk frame'),
                TextInput::make('jenis_lensa')
                    ->label('Jenis Lensa')
                    ->placeholder('Masukkan jenis lensa'),
                TextInput::make('harga_frame')
                    ->label('Harga Frame')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->placeholder('Masukkan harga frame'),
                TextInput::make('harga_lensa')
                    ->label('Harga Lensa')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->placeholder('Masukkan harga lensa'),
                Section::make('Right Eye')
                ->columns([
                    'sm' => 5,
                ])
                ->schema([
                    TextInput::make('r_sph')
                    ->label('SPH')
                    ->columnSpan(1)
                    ->rule('regex:/^[+-]?\d+(\,\d+)?$/'),
                    TextInput::make('r_cyl')
                    ->label('CYL')
                    ->columnSpan(1)
                    ->rule('regex:/^[+-]?\d+(\,\d+)?$/'),
                    TextInput::make('r_axis')
                    ->label('AXIS')
                    ->columnSpan(1)
                    ->rule('regex:/^[+-]?\d+(\,\d+)?$/'),
                    TextInput::make('r_add')
                    ->label('ADD')
                    ->columnSpan(1)
                    ->rule('regex:/^[+-]?\d+(\,\d+)?$/'),
                    TextInput::make('r_pd')
                    ->label('PD')
                    ->columnSpan(1)
                    ->rule('regex:/^[+-]?\d+(\,\d+)?$/'),
                ]),
                Section::make('Left Eye')
                ->columns([
                    'sm' => 5,
                ])
                ->schema([
                    TextInput::make('l_sph')
                    ->label('SPH')
                    ->columnSpan(1)
                    ->rule('regex:/^[+-]?\d+(\,\d+)?$/'),
                    TextInput::make('l_cyl')
                    ->label('CYL')
                    ->columnSpan(1)
                    ->rule('regex:/^[+-]?\d+(\,\d+)?$/'),
                    TextInput::make('l_axis')
                    ->label('AXIS')
                    ->columnSpan(1)
                    ->rule('regex:/^[+-]?\d+(\,\d+)?$/'),
                    TextInput::make('l_add')
                    ->label('ADD')
                    ->columnSpan(1)
                    ->rule('regex:/^[+-]?\d+(\,\d+)?$/'),
                    TextInput::make('l_pd')
                    ->label('PD')
                    ->columnSpan(1)
                    ->rule('regex:/^[+-]?\d+(\,\d+)?$/'),
                ]),
                TextInput::make('total')
                    ->label('Total Harga')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->placeholder('Masukkan total harga'),
                TextInput::make('bayar')
                    ->label('Jumlah Bayar/DP')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->placeholder('Masukkan jumlah bayar/DP'),
                TextInput::make('kurang')
                    ->label('Jumlah Kekurangan Pembayaran')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->placeholder('Masukkan jumlah kekurangan pembayaran'),
                Select::make('status')
                    ->options([
                        'Belum Diambil' => 'Belum Diambil',
                        'Diambil' => 'Diambil',
                    ])->native(false)->required(),
                    Textarea::make('note')
                    ->placeholder('Masukkan catatan')
                    ->rows(4)
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                ->searchable(),
                TextColumn::make('no_telp'),
                TextColumn::make('total')
                ->money('IDR'),
                TextColumn::make('bayar')
                ->money('IDR'),
                TextColumn::make('kurang')
                ->money('IDR'),
                TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Belum Diambil' => 'danger',
                    'Diambil' => 'success',
                }),
                TextColumn::make('created_at')
                ->date(),
                TextColumn::make('updated_at')
                ->date()
            ])
            ->filters([
                SelectFilter::make('status')
                ->options([
                    'Belum Diambil' => 'Belum Diambil',
                    'Diambil' => 'Diambil',
                ]),
                Filter::make('created_at')
                ->schema([
                    DatePicker::make('created_from'),
                    DatePicker::make('created_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })
            ])
            ->recordActions([
                ViewAction::make(),
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
            'index' => ListTransactions::route('/'),
            'create' => CreateTransaction::route('/create'),
            'view' => ViewTransaction::route('/{record}'),
            'edit' => EditTransaction::route('/{record}/edit'),
        ];
    }
}
