<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Acer Predator',
                'price' => 200,
                'image' => 'image/Accer-Predator.jpg',
                'desc' => 'Gaming laptop',
                'category' => 'Gaming',
                'stock' => 'in-stock',
                'specifications' => [
                    'Processor' => 'Intel i9-13900HX',
                    'GPU' => 'RTX 4080 12GB',
                    'RAM' => '32GB DDR5',
                    'Storage' => '2TB NVMe SSD'
                ]
            ],
            [
                'name' => 'Asus ROG Strix',
                'price' => 200,
                'image' => 'image/rog-strix.png',
                'desc' => 'High-end performance',
                'category' => 'Gaming',
                'stock' => 'low-stock',
                'specifications' => [
                    'Processor' => 'AMD Ryzen 9',
                    'GPU' => 'RTX 4090 16GB',
                    'Display' => '18" QHD 240Hz',
                    'Storage' => '4TB SSD RAID 0'
                ]
            ],
            [
                'name' => 'MSI Katana',
                'price' => 200,
                'image' => 'image/msi-katana.jpg',
                'desc' => 'Affordable gaming laptop',
                'category' => 'Gaming',
                'stock' => 'in-stock',
                'specifications' => [
                    'Processor' => 'Intel i7-13620H',
                    'GPU' => 'RTX 4060 8GB',
                    'RAM' => '16GB DDR5',
                    'Display' => '15.6" FHD 144Hz'
                ]
            ],
            [
                'name' => 'MacBook Pro 14" M3',
                'price' => 200,
                'image' => 'image/Macbook-Pro-14.jpg',
                'desc' => 'Supercharged by M3 chip with 8-core CPU, 10-core GPU, 8GB Unified Memory.',
                'category' => 'Premium',
                'stock' => 'in-stock',
                'specifications' => [
                    'Chip' => 'Apple M3',
                    'Memory' => '8GB Unified',
                    'Storage' => '512GB SSD',
                    'Display' => '14.2" XDR'
                ]
            ],
            [
                'name' => 'Dell XPS 13 Plus',
                'price' => 200,
                'image' => 'image/Dell-XPS-13-Plus.jpg',
                'desc' => 'Ultra-thin laptop with edge-to-edge keyboard, haptic touchpad, and InfinityEdge display.',
                'category' => 'Ultrabook',
                'stock' => 'out-of-stock',
                'specifications' => [
                    'Processor' => 'Intel i7-1360P',
                    'RAM' => '16GB LPDDR5',
                    'Storage' => '1TB NVMe SSD',
                    'Display' => '13.4" OLED 3.5K'
                ]
            ],
            [
                'name' => 'HP Spectre x360',
                'price' => 200,
                'image' => 'image/HP-Envy x360.jpg',
                'desc' => '2-in-1 convertible laptop with OLED display, Bang & Olufsen speakers, and pen support.',
                'category' => 'Convertible',
                'stock' => 'in-stock',
                'specifications' => [
                    'Processor' => 'Intel i7-1355U',
                    'RAM' => '16GB DDR4',
                    'Storage' => '512GB SSD',
                    'Display' => '13.5" OLED Touch'
                ]
            ],
            [
                'name' => 'Lenovo ThinkPad X1 Carbon',
                'price' => 200,
                'image' => 'image/Lenovo-ThinkPad-X1-Carbon.jpg',
                'desc' => 'Legendary business laptop with military-grade durability and best-in-class keyboard.',
                'category' => 'Business',
                'stock' => 'in-stock',
                'specifications' => [
                    'Processor' => 'Intel i7-1365U',
                    'RAM' => '32GB LPDDR5',
                    'Storage' => '1TB SSD',
                    'Weight' => '2.48 lbs'
                ]
            ],
            [
                'name' => 'Razer Blade 16',
                'price' => 200,
                'image' => 'image/Razer-Blade-16.jpg',
                'desc' => 'World\'s first dual-mode mini-LED gaming laptop with switchable native resolutions.',
                'category' => 'Gaming',
                'stock' => 'low-stock',
                'specifications' => [
                    'Processor' => 'Intel i9-13950HX',
                    'GPU' => 'RTX 4090 16GB',
                    'Display' => '16" Dual-Mode Mini-LED',
                    'Storage' => '2TB SSD'
                ]
            ],
            [
                'name' => 'Surface Laptop Studio',
                'price' => 200,
                'image' => 'image/Surface-Laptop-Studio.jpg',
                'desc' => 'Versatile laptop that transforms from laptop to creative studio with dynamic woven hinge.',
                'category' => 'Creative',
                'stock' => 'in-stock',
                'specifications' => [
                    'Processor' => 'Intel i7-11370H',
                    'GPU' => 'RTX 3050 Ti 4GB',
                    'Display' => '14.4" PixelSense',
                    'Storage' => '1TB SSD'
                ]
            ],
            [
                'name' => 'Alienware m18',
                'price' => 200,
                'image' => 'image/Alienware-m18.jpg',
                'desc' => 'Massive 18-inch gaming laptop with Cryo-Tech cooling and AlienFX RGB lighting.',
                'category' => 'Gaming',
                'stock' => 'in-stock',
                'specifications' => [
                    'Processor' => 'AMD Ryzen 9 7845HX',
                    'GPU' => 'RTX 4090 16GB',
                    'Display' => '18" QHD+ 165Hz',
                    'RAM' => '64GB DDR5'
                ]
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
