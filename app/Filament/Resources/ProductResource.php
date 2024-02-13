<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Fields\BelongsTo;
use Filament\Fields\File;
use Filament\Fields\HasMany;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                ->required(),
                TextInput::make('ref')
                ->required(),
                Select::make('category_id')
                ->label('Category')
                ->options(Category::all()->pluck('name', 'id'))
                ->searchable()
                ->required(),
                
            ColorPicker::make('color')->required(),

            SpatieMediaLibraryFileUpload::make('image')
            ->image()
            ->imageEditor()
            ->multiple()
            // ->media()
            // ->directory('product') // Directory in storage/app/public
            // ->disk('public') // Ensure you've linked storage using `php artisan storage:link`
            // ->preserveFilenames()
            // ->image()
            // ->imageEditor(), // Optional: ensures only images can be uploaded
            ])
            ->columnSpan(1)
            ->collapsible(),

            

            Section::make('All Description Type :')
            ->schema([
                MarkdownEditor::make('long_desc')->required(),
                Textarea::make('short_desc')->required(),
                Textarea::make('info_supp')->required(),
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
                ColorColumn::make('color')
                ->searchable()
                ->sortable(),
                SelectColumn::make('category_id')
                ->label('Category')
                ->options(Category::all()->pluck('name', 'id'))
                ->searchable()
                ->sortable(),

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

//     protected function afterSave(Form $form, $record): void
// {
//     $images = $form->getState('images') ?? [];

//     foreach ($images as $imageFile) {
//         $filename = $imageFile->getClientOriginalName();
//         $path = $imageFile->store('product', 'public');

//         $record->images()->create([
//             'filename' => $filename,
//             'path' => $path,
//         ]);
//     }
// }

}
