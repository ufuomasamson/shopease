<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class PhysicalProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories
        $categories = [
            'Electronics' => [
                'Phones & Tablets' => [
                    'Smartphones',
                    'Tablets',
                    'Phone Accessories',
                    'Tablet Accessories'
                ],
                'Computing' => [
                    'Laptops',
                    'Desktop Computers',
                    'Computer Accessories',
                    'Software'
                ],
                'TV & Audio' => [
                    'Televisions',
                    'Home Audio',
                    'Headphones',
                    'Speakers'
                ]
            ],
            'Fashion' => [
                'Men\'s Fashion' => [
                    'Men\'s Clothing',
                    'Men\'s Shoes',
                    'Men\'s Accessories',
                    'Men\'s Watches'
                ],
                'Women\'s Fashion' => [
                    'Women\'s Clothing',
                    'Women\'s Shoes',
                    'Women\'s Accessories',
                    'Women\'s Bags'
                ],
                'Kids & Baby' => [
                    'Baby Clothing',
                    'Kids Clothing',
                    'Kids Shoes',
                    'Baby Care'
                ]
            ],
            'Home & Living' => [
                'Furniture' => [
                    'Living Room',
                    'Bedroom',
                    'Kitchen & Dining',
                    'Office Furniture'
                ],
                'Home Decor' => [
                    'Wall Art',
                    'Cushions & Throws',
                    'Curtains & Blinds',
                    'Rugs & Carpets'
                ],
                'Kitchen & Dining' => [
                    'Cookware',
                    'Dinnerware',
                    'Kitchen Appliances',
                    'Storage & Organization'
                ]
            ],
            'Sports & Outdoor' => [
                'Sports Equipment' => [
                    'Fitness Equipment',
                    'Team Sports',
                    'Individual Sports',
                    'Outdoor Sports'
                ],
                'Outdoor & Camping' => [
                    'Camping Gear',
                    'Hiking Equipment',
                    'Fishing Gear',
                    'Outdoor Clothing'
                ]
            ],
            'Beauty & Personal Care' => [
                'Skincare' => [
                    'Facial Care',
                    'Body Care',
                    'Sun Protection',
                    'Anti-Aging'
                ],
                'Makeup' => [
                    'Face Makeup',
                    'Eye Makeup',
                    'Lip Makeup',
                    'Makeup Tools'
                ],
                'Hair Care' => [
                    'Shampoo & Conditioner',
                    'Hair Styling',
                    'Hair Accessories',
                    'Hair Tools'
                ]
            ],
            'Automotive' => [
                'Car Accessories' => [
                    'Interior Accessories',
                    'Exterior Accessories',
                    'Car Electronics',
                    'Car Care'
                ],
                'Motorcycle' => [
                    'Motorcycle Parts',
                    'Motorcycle Accessories',
                    'Motorcycle Gear',
                    'Motorcycle Tools'
                ]
            ]
        ];

        // Create Brands
        $brands = [
            'Electronics' => ['Samsung', 'Apple', 'Sony', 'LG', 'Panasonic', 'Philips', 'Toshiba', 'Sharp'],
            'Fashion' => ['Nike', 'Adidas', 'Puma', 'Reebok', 'Levi\'s', 'Calvin Klein', 'Tommy Hilfiger', 'Ralph Lauren'],
            'Home & Living' => ['IKEA', 'Ashley Furniture', 'Pottery Barn', 'West Elm', 'Crate & Barrel', 'Restoration Hardware'],
            'Sports & Outdoor' => ['Under Armour', 'Columbia', 'The North Face', 'Patagonia', 'Nike', 'Adidas'],
            'Beauty & Personal Care' => ['L\'Oreal', 'Maybelline', 'Revlon', 'CoverGirl', 'MAC', 'Estee Lauder'],
            'Automotive' => ['Bosch', 'NGK', 'Mobil 1', 'Castrol', 'Shell', 'Valvoline']
        ];

        // Create Categories and Subcategories
        foreach ($categories as $mainCategory => $subCategories) {
            $mainCat = Category::create([
                'name' => $mainCategory,
                'slug' => 'main-' . strtolower(str_replace([' ', '&', '\''], ['-', 'and', ''], $mainCategory)),
                'description' => "Shop the best {$mainCategory} products online",
                'icon' => $this->getCategoryIcon($mainCategory),
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1
            ]);

            foreach ($subCategories as $subCategory => $childCategories) {
                $subCat = Category::create([
                    'name' => $subCategory,
                    'slug' => 'sub-' . strtolower(str_replace([' ', '&', '\''], ['-', 'and', ''], $subCategory)),
                    'description' => "Discover amazing {$subCategory} products",
                    'icon' => $this->getCategoryIcon($subCategory),
                    'parent_id' => $mainCat->id,
                    'is_active' => true,
                    'sort_order' => 2
                ]);

                foreach ($childCategories as $childCategory) {
                    Category::create([
                        'name' => $childCategory,
                        'slug' => 'child-' . strtolower(str_replace([' ', '&', '\''], ['-', 'and', ''], $childCategory)),
                        'description' => "Premium {$childCategory} selection",
                        'icon' => $this->getCategoryIcon($childCategory),
                        'parent_id' => $subCat->id,
                        'is_active' => true,
                        'sort_order' => 3
                    ]);
                }
            }
        }

        // Create Brands
        $allBrands = [];
        foreach ($brands as $category => $brandList) {
            foreach ($brandList as $brandName) {
                if (!in_array($brandName, $allBrands)) {
                    $allBrands[] = $brandName;
                }
            }
        }

        foreach ($allBrands as $brandName) {
            Brand::create([
                'name' => $brandName,
                'slug' => 'brand-' . strtolower(str_replace([' ', '&', '\''], ['-', 'and', ''], $brandName)),
                'description' => "Premium {$brandName} products for quality and style",
                'country' => $this->getBrandCountry($brandName),
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => rand(1, 10)
            ]);
        }

        // Create Sample Products
        $this->createSampleProducts();
    }

    private function createSampleProducts(): void
    {
        $products = [
            // Electronics - Smartphones
            [
                'title' => 'Samsung Galaxy S24 Ultra',
                'brand' => 'Samsung',
                'category' => 'Smartphones',
                'subcategory' => 'Phones & Tablets',
                'description' => 'Latest Samsung flagship with S Pen, 200MP camera, and AI features',
                'price' => 1199.99,
                'original_price' => 1299.99,
                'discount_percentage' => 7.69,
                'stock' => 45,
                'weight' => 0.232,
                'dimensions' => '16.3 x 7.9 x 0.9',
                'color' => 'Titanium Gray',
                'is_featured' => true,
                'is_on_sale' => true,
                'is_new_arrival' => true,
                'shipping_weight' => '0.3kg',
                'shipping_class' => 'express',
                'shipping_days' => 2,
                'free_shipping' => true,
                'features' => ['200MP Camera', 'S Pen', 'AI Features', '5G', '5000mAh Battery'],
                'specifications' => [
                    'Display' => '6.8" Dynamic AMOLED 2X',
                    'Processor' => 'Snapdragon 8 Gen 3',
                    'RAM' => '12GB',
                    'Storage' => '256GB',
                    'Camera' => '200MP + 12MP + 50MP + 10MP'
                ],
                'warranty_info' => '2 Years Manufacturer Warranty',
                'return_policy' => '30 Days Return Policy',
                'min_order_quantity' => 1,
                'max_order_quantity' => 5,
                'status' => 'active'
            ],
            [
                'title' => 'iPhone 15 Pro Max',
                'brand' => 'Apple',
                'category' => 'Smartphones',
                'subcategory' => 'Phones & Tablets',
                'description' => 'Apple\'s most powerful iPhone with A17 Pro chip and titanium design',
                'price' => 1199.99,
                'original_price' => 1199.99,
                'discount_percentage' => 0,
                'stock' => 38,
                'weight' => 0.221,
                'dimensions' => '15.9 x 7.8 x 0.8',
                'color' => 'Natural Titanium',
                'is_featured' => true,
                'is_new_arrival' => true,
                'shipping_weight' => '0.3kg',
                'shipping_class' => 'express',
                'shipping_days' => 2,
                'free_shipping' => true,
                'features' => ['A17 Pro Chip', 'Titanium Design', 'Action Button', 'USB-C', '48MP Camera'],
                'specifications' => [
                    'Display' => '6.7" Super Retina XDR',
                    'Processor' => 'A17 Pro',
                    'RAM' => '8GB',
                    'Storage' => '256GB',
                    'Camera' => '48MP + 12MP + 12MP'
                ],
                'warranty_info' => '1 Year Apple Warranty',
                'return_policy' => '14 Days Return Policy',
                'min_order_quantity' => 1,
                'max_order_quantity' => 3,
                'status' => 'active'
            ],
            // Fashion - Men's Clothing
            [
                'title' => 'Nike Dri-FIT Training T-Shirt',
                'brand' => 'Nike',
                'category' => 'Men\'s Clothing',
                'subcategory' => 'Men\'s Fashion',
                'description' => 'Lightweight, breathable training shirt with moisture-wicking technology',
                'price' => 34.99,
                'original_price' => 44.99,
                'discount_percentage' => 22.22,
                'stock' => 120,
                'weight' => 0.15,
                'dimensions' => '30 x 20 x 2',
                'color' => 'Black',
                'size' => 'L',
                'material' => 'Polyester',
                'is_featured' => false,
                'is_on_sale' => true,
                'shipping_weight' => '0.2kg',
                'shipping_class' => 'standard',
                'shipping_days' => 5,
                'free_shipping' => false,
                'shipping_cost' => 5.99,
                'features' => ['Moisture-Wicking', 'Breathable', 'Quick-Dry', 'Comfortable Fit'],
                'specifications' => [
                    'Material' => '100% Polyester',
                    'Fit' => 'Regular',
                    'Care' => 'Machine Washable',
                    'UPF' => 'UPF 50+'
                ],
                'warranty_info' => 'No Warranty',
                'return_policy' => '60 Days Return Policy',
                'min_order_quantity' => 1,
                'max_order_quantity' => 10,
                'status' => 'active'
            ],
            // Home & Living - Furniture
            [
                'title' => 'Modern L-Shaped Sofa',
                'brand' => 'Ashley Furniture',
                'category' => 'Living Room',
                'subcategory' => 'Furniture',
                'description' => 'Contemporary L-shaped sectional sofa with premium fabric upholstery',
                'price' => 899.99,
                'original_price' => 1299.99,
                'discount_percentage' => 30.77,
                'stock' => 8,
                'weight' => 45.0,
                'dimensions' => '280 x 180 x 85',
                'color' => 'Charcoal Gray',
                'material' => 'Polyester Blend',
                'is_featured' => true,
                'is_on_sale' => true,
                'shipping_weight' => '50kg',
                'shipping_class' => 'furniture',
                'shipping_days' => 7,
                'free_shipping' => false,
                'shipping_cost' => 99.99,
                'features' => ['L-Shaped Design', 'Premium Fabric', 'Comfortable Cushions', 'Easy Assembly'],
                'specifications' => [
                    'Dimensions' => '280"W x 180"D x 85"H',
                    'Material' => 'Polyester Blend',
                    'Frame' => 'Solid Wood',
                    'Assembly' => 'Required'
                ],
                'warranty_info' => '5 Years Frame Warranty',
                'return_policy' => '30 Days Return Policy',
                'min_order_quantity' => 1,
                'max_order_quantity' => 2,
                'status' => 'active'
            ],
            // Sports & Outdoor
            [
                'title' => 'Under Armour HOVR Running Shoes',
                'brand' => 'Under Armour',
                'category' => 'Individual Sports',
                'subcategory' => 'Sports Equipment',
                'description' => 'Lightweight running shoes with HOVR cushioning technology',
                'price' => 89.99,
                'original_price' => 119.99,
                'discount_percentage' => 25.00,
                'stock' => 65,
                'weight' => 0.28,
                'dimensions' => '30 x 12 x 8',
                'color' => 'White/Black',
                'size' => '10',
                'material' => 'Mesh & Synthetic',
                'is_featured' => false,
                'is_on_sale' => true,
                'shipping_weight' => '0.4kg',
                'shipping_class' => 'standard',
                'shipping_days' => 5,
                'free_shipping' => false,
                'shipping_cost' => 7.99,
                'features' => ['HOVR Cushioning', 'Breathable Mesh', 'Lightweight', 'Durable Outsole'],
                'specifications' => [
                    'Weight' => '280g',
                    'Drop' => '8mm',
                    'Terrain' => 'Road',
                    'Arch Support' => 'Neutral'
                ],
                'warranty_info' => '1 Year Warranty',
                'return_policy' => '90 Days Return Policy',
                'min_order_quantity' => 1,
                'max_order_quantity' => 5,
                'status' => 'active'
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }

    private function getCategoryIcon(string $category): string
    {
        $icons = [
            'Electronics' => 'fas fa-mobile-alt',
            'Phones & Tablets' => 'fas fa-mobile-alt',
            'Smartphones' => 'fas fa-mobile-alt',
            'Tablets' => 'fas fa-tablet-alt',
            'Computing' => 'fas fa-laptop',
            'Laptops' => 'fas fa-laptop',
            'TV & Audio' => 'fas fa-tv',
            'Fashion' => 'fas fa-tshirt',
            'Men\'s Fashion' => 'fas fa-male',
            'Women\'s Fashion' => 'fas fa-female',
            'Kids & Baby' => 'fas fa-baby',
            'Home & Living' => 'fas fa-home',
            'Furniture' => 'fas fa-couch',
            'Home Decor' => 'fas fa-palette',
            'Kitchen & Dining' => 'fas fa-utensils',
            'Sports & Outdoor' => 'fas fa-running',
            'Sports Equipment' => 'fas fa-dumbbell',
            'Outdoor & Camping' => 'fas fa-campground',
            'Beauty & Personal Care' => 'fas fa-spa',
            'Skincare' => 'fas fa-pump-soap',
            'Makeup' => 'fas fa-palette',
            'Hair Care' => 'fas fa-cut',
            'Automotive' => 'fas fa-car',
            'Car Accessories' => 'fas fa-tools',
            'Motorcycle' => 'fas fa-motorcycle'
        ];

        return $icons[$category] ?? 'fas fa-box';
    }

    private function getBrandCountry(string $brand): string
    {
        $countries = [
            'Samsung' => 'South Korea',
            'Apple' => 'United States',
            'Sony' => 'Japan',
            'LG' => 'South Korea',
            'Panasonic' => 'Japan',
            'Philips' => 'Netherlands',
            'Toshiba' => 'Japan',
            'Sharp' => 'Japan',
            'Nike' => 'United States',
            'Adidas' => 'Germany',
            'Puma' => 'Germany',
            'Reebok' => 'United States',
            'Levi\'s' => 'United States',
            'Calvin Klein' => 'United States',
            'Tommy Hilfiger' => 'United States',
            'Ralph Lauren' => 'United States',
            'IKEA' => 'Sweden',
            'Ashley Furniture' => 'United States',
            'Pottery Barn' => 'United States',
            'West Elm' => 'United States',
            'Crate & Barrel' => 'United States',
            'Restoration Hardware' => 'United States',
            'Under Armour' => 'United States',
            'Columbia' => 'United States',
            'The North Face' => 'United States',
            'Patagonia' => 'United States',
            'L\'Oreal' => 'France',
            'Maybelline' => 'United States',
            'Revlon' => 'United States',
            'CoverGirl' => 'United States',
            'MAC' => 'United States',
            'Estee Lauder' => 'United States',
            'Bosch' => 'Germany',
            'NGK' => 'Japan',
            'Mobil 1' => 'United States',
            'Castrol' => 'United Kingdom',
            'Shell' => 'Netherlands',
            'Valvoline' => 'United States'
        ];

        return $countries[$brand] ?? 'United States';
    }
}
