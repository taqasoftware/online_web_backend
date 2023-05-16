<?php
use App\Models\User;
use App\Models\Region;
use App\Models\Origin;
use App\Models\Costumer;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);
        $agentRole = Role::create(['name' => 'agent']);
        $admin = User::create([
            'name' => 'ssssssss',
            'password' => bcrypt('ssssssss'),
            'is_active' => 1,
        ]);

        $agent = User::create([
            'name' => 'aaaaaaaa',
            'password' => bcrypt('aaaaaaaa'),
            'is_active' => 1,
        ]);

        $admin->assignRole($adminRole);
        $agent->assignRole($agentRole);
 

            // Create 10 Region records
            for ($i = 0; $i < 10; $i++) {
                Region::create([
                    'RegName' => 'Region ' . ($i + 1),
                ]);
            }

            // Create 10 Origin records
            for ($i = 0; $i < 10; $i++) {
                Origin::create([
                    'OrgName' => 'Origin ' . ($i + 1),
                ]);
            }

            // Get all regions
            $regions = Region::all();

            // Create 10 Product records
            for ($i = 0; $i < 10; $i++) {
                Product::create([
                    'ProdName' => 'Product ' . ($i + 1),
                    'ProdOrgID' => 1,
                    'ProdSalePrice1' => 10.99,
                    'ProdSalePrice2' => 19.99,
                    'ProdSalePrice3' => 29.99,
                    'ProdSalePrice4' => 39.99,
                    'ProdGiftBonus' => 5,
                    'ProdGiftQTY' => 1,
                    'ProdNote' => 'Product ' . ($i + 1) . ' description',
                    'ProdCurrentBalance' => 100,
                ]);
            }

            // Create 10 Customer records
            for ($i = 0; $i < 10; $i++) {
                Costumer::create([
                    'CustName' => 'Customer ' . ($i + 1),
                    // 'CustPriceCatID' => 1,
                    'CustRegionID' => 2,
                    'CustQIDBalance' => 100,
                    'CustUSDBanace' => 200,
                ]);
            }
        }
    }


