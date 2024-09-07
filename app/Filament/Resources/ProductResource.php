<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
    ->schema([
        Forms\Components\TextInput::make('name')
            ->label('Nama Product')
            ->required()
            ->maxLength(255)
            ->reactive()
            ->afterStateUpdated(function ($state, callable $set) {
                $set('url', \Str::slug($state)); 
            }),
        Forms\Components\TextInput::make('price')
            ->label('Harga Product')
            ->required()
            ->maxLength(255),
        Forms\Components\Toggle::make('is_available')
            ->label('Apakah Tersedia?')
            ->default(true) 
            ->required(),
        Forms\Components\TextInput::make('url')
            ->label('URL')
            ->required()
            ->maxLength(255)
            ->readonly()  
            ->default(fn ($get) => \Str::slug($get('name'))),
            Forms\Components\FileUpload::make('images')
            ->label('Images')
            ->directory('product') 
            ->multiple() 
            ->nullable(),

    ]);

    }

    public static function table(Table $table): Table
    {
        return $table
       
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Produk')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga Produk')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('url')
                    ->label('URL Produk')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('is_available')
                    ->label('Tersedia')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return $state ? 'Yes' : 'No';
                    }),
                    
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
