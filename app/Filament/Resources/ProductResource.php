<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\ColorEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\Tabs;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists\Infolist;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([

            Section::make('Create New Product')
            ->schema([
                TextInput::make('name')
                ->required()
                ->placeholder('name'),
                TextInput::make('ref')
                ->label('Referance')
                ->required()
                ->placeholder('referance'),
                Select::make('category_id')
                ->label('Category')
                ->options(Category::all()->pluck('name', 'id'))
                ->searchable()
                ->required(),
                TextInput::make('taille')
                ->required()
                ->placeholder('Format */*'),
                
            ColorPicker::make('color')->required()->placeholder('Choise Color Code #00ff25'),

            SpatieMediaLibraryFileUpload::make('image')
            ->image()
            ->imageEditor()
            ->multiple()
            ])
            ->columnSpan(1)
            ->collapsible(),

            

            Section::make('All Description Type :')
            ->schema([
                MarkdownEditor::make('long_desc')->label('Long Description')->required()->placeholder('Enter long Description'),
                Textarea::make('short_desc')->label('Short Description')->required()->placeholder('Enter Short Description'),
                Textarea::make('info_supp')->label('Additional Information')->required()->placeholder('Enter more information about product'),
            ])
            ->columnSpan(1)
            ->collapsible(),

            Section::make()->schema([
                ToggleButtons::make('status')
                ->required()
                ->options([
                    'En Stock' => 'EnStock',
                    'Epuisé' => 'Epuisé',])
                    ->colors([
                    'Epuisé' => 'danger',
                    'En Stock' => 'success',
                    ])
                    ->grouped(),

                ToggleButtons::make('display')
                ->required()
                ->colors([
                    'Hide' => 'danger',
                    'Show' => 'success',])
                ->grouped()
                ->options([
                    'Show' => 'Show',
                    'Hide' => 'Hide',
                 
                ]),
            ])
            ->columns(2)
            ->columnSpan(1),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name')
                ->searchable()
                ->sortable(),
                TextColumn::make('ref')
                ->searchable()
                ->sortable(), 
                TextColumn::make('taille')
                ->searchable()
                ->sortable(),
                ColorColumn::make('color')
                ->searchable()
                ->sortable(),
                SelectColumn::make('category_id')
                ->label('Category')
                ->options(Category::all()->pluck('name', 'id'))
                ->searchable()
                ->sortable(),
                SpatieMediaLibraryImageColumn::make('image'),
                IconColumn::make('status')
                ->color(fn (string $state): string => match ($state) {
                    'Epuisé' => 'danger',
                    'En Stock' => 'success',
                    })
                ->icon(fn (string $state): string => match ($state) {
                    'En Stock' => 'heroicon-o-check-circle',
                    'Epuisé' => 'heroicon-o-x-circle',
                })->searchable()
                ->sortable()

                ])

                ->filters([
                
                SelectFilter::make('category_id')
                ->label('Category')
                ->options(Category::all()->pluck('name', 'id'))
                ->preload(),

                SelectFilter::make('status')
                    ->options([
                        'Epuisé' => 'Epuisé',
                        'En Stock' => 'En Stock',
                    ])->preload(),
                    
                ], layout: FiltersLayout::AboveContent)->filtersFormColumns(2)
                
            
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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

        public static function infolist(Infolist $infolist): Infolist
    {
            return $infolist
                ->schema([
                Tabs::make('Tabs')
                ->tabs([
                Tabs\Tab::make('Product Details')
                    ->icon('heroicon-m-document-magnifying-glass')
                    ->schema([
                        TextEntry::make('name')->label('Product Name :'),
                        TextEntry::make('ref')->label('Referance :'),
                        TextEntry::make('category.name')->label('Product Category :'),
                    ])

                    ->columns(3)
                    ->columnSpanFull(),

                    Tabs\Tab::make('Product Description')
                    ->icon('heroicon-m-chat-bubble-bottom-center-text')
                    ->schema([
                        TextEntry::make('long_desc')->label('Long Description :'),
                        TextEntry::make('short_desc')->label('Short Description :'),
                        TextEntry::make('info_supp')->label('Additional Information :'),
                    ])

                    ->columns(3)
                    ->columnSpanFull(),

                Tabs\Tab::make('More Details')
                    ->icon('heroicon-m-ellipsis-horizontal-circle')
                    ->schema([
                        ColorEntry::make('color')->label('Product Color :'),
                        TextEntry::make('taille')->label('Taille :'),
                        IconEntry::make('status')
                        ->color(fn (string $state): string => match ($state) {
                            'Epuisé' => 'danger',
                            'En Stock' => 'success',
                            })
                        ->icon(fn (string $state): string => match ($state) {
                            'En Stock' => 'heroicon-o-check-circle',
                            'Epuisé' => 'heroicon-o-x-circle',
                        }),

                        IconEntry::make('display')
                        ->color(fn (string $state): string => match ($state) {
                            'Hide' => 'danger',
                            'Show' => 'success',
                            })
                        ->icon(fn (string $state): string => match ($state) {
                            'Show' => 'heroicon-o-check-circle',
                            'Hide' => 'heroicon-o-x-circle',
                        }),

                    ])
                    ->columns(4)
                    ->columnSpanFull(),

                Tabs\Tab::make('Product Images')
                    ->icon('heroicon-m-photo')
                    ->schema([
                    SpatieMediaLibraryImageEntry::make('image')->label('Product Images :'),
                    ]),
                ])->columnSpanFull()
                ]);
    }

    // public static function infolist(Infolist $infolist): Infolist
    // {
    //         return $infolist
    //             ->schema([
    //                 Filament\Infolists\Components\Section::make('Product Details :')
    //                 ->schema([
    //                 TextEntry::make('name')->label('Product Name :'),
    //                 TextEntry::make('ref')->label('Referance :'),
    //                 TextEntry::make('long_desc')->label('Long Description :'),
    //                 TextEntry::make('short_desc')->label('Short Description :'),
    //                 TextEntry::make('info_supp')->label('Additional Information :'),
    //                 TextEntry::make('category.name')->label('Product Category :'),
    //                 ])->columns(2),

    //                 Filament\Infolists\Components\Section::make('Other Details :')
    //                 ->schema([
    //                 ColorEntry::make('color')->label('Product Color :'),
    //                 TextEntry::make('taille')->label('Taille :'),
    //                 IconEntry::make('status')
    //                 ->color(fn (string $state): string => match ($state) {
    //                     'Epuisé' => 'danger',
    //                     'En Stock' => 'success',
    //                     })
    //                 ->icon(fn (string $state): string => match ($state) {
    //                     'En Stock' => 'heroicon-o-check-circle',
    //                     'Epuisé' => 'heroicon-o-x-circle',
    //                 }),

    //                 IconEntry::make('display')
    //                 ->color(fn (string $state): string => match ($state) {
    //                     'Hide' => 'danger',
    //                     'Show' => 'success',
    //                     })
    //                 ->icon(fn (string $state): string => match ($state) {
    //                     'Show' => 'heroicon-o-check-circle',
    //                     'Hide' => 'heroicon-o-x-circle',
    //                 }),

    //                 ])->columnSpanFull(),

    //                 Filament\Infolists\Components\Section::make('Other Details :')
    //                 ->schema([
    //                     SpatieMediaLibraryImageEntry::make('image')->label('Product Images :'),
    //                 ])
    //         ]);
    // }
    

    // public static function infolist(Infolist $infolist): Infolist
    // {
    //         return $infolist
    //             ->schema([
    //             Grid::make('Product Details :')
    //             ->schema([
    //             TextEntry::make('name')->label('Product Name :'),
    //             TextEntry::make('ref')->label('Referance :'),
    //             TextEntry::make('long_desc')->label('Long Description :'),
    //             TextEntry::make('short_desc')->label('Short Description :'),
    //             TextEntry::make('info_supp')->label('Additional Information :'),
    //             TextEntry::make('category.name')->label('Product Category :'),
    //             ])->columns(2),

    //             // Section::make('Other Details :')
    //             // ->schema([
    //             // ColorEntry::make('color')->label('Product Color :'),
    //             // TextEntry::make('taille')->label('Taille :'),
    //             // IconEntry::make('status')
    //             // ->color(fn (string $state): string => match ($state) {
    //             //     'Epuisé' => 'danger',
    //             //     'En Stock' => 'success',
    //             //     })
    //             // ->icon(fn (string $state): string => match ($state) {
    //             //     'En Stock' => 'heroicon-o-check-circle',
    //             //     'Epuisé' => 'heroicon-o-x-circle',
    //             // }),

    //             // IconEntry::make('display')
    //             // ->color(fn (string $state): string => match ($state) {
    //             //     'Hide' => 'danger',
    //             //     'Show' => 'success',
    //             //     })
    //             // ->icon(fn (string $state): string => match ($state) {
    //             //     'Show' => 'heroicon-o-check-circle',
    //             //     'Hide' => 'heroicon-o-x-circle',
    //             // }),

    //             // ])->columnSpanFull(),

    //             // Section::make('Other Details :')
    //             // ->schema([
    //             //     SpatieMediaLibraryImageEntry::make('image')->label('Product Images :'),
    //             // ])
    //         ]);
    // }

}
