<?php

namespace Database\Seeders;

use App\Models\Shipment;
use App\Models\ShipmentUpdate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ShipmentSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@blueorientlogistics.org'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create demo customer
        $customer = User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        // ── Shipment 1: New York → London (In Transit) ──
        $s1 = Shipment::create([
            'user_id' => $customer->id,
            'tracking_number' => 'BLU-NYC2LDN1',
            'sender_name' => 'John Doe',
            'sender_email' => 'john@example.com',
            'sender_phone' => '+1 (555) 123-4567',
            'sender_address' => '350 5th Ave, New York, NY 10118, USA',
            'receiver_name' => 'Jane Smith',
            'receiver_email' => 'jane@example.co.uk',
            'receiver_phone' => '+44 20 7946 0958',
            'receiver_address' => '221B Baker Street, London NW1 6XE, UK',
            'package_description' => 'Electronics - Laptop and accessories',
            'weight' => 3.50,
            'package_type' => 'parcel',
            'status' => 'in_transit',
            'origin_lat' => 40.7484,
            'origin_lng' => -73.9857,
            'destination_lat' => 51.5238,
            'destination_lng' => -0.1585,
            'current_lat' => 48.8566,
            'current_lng' => 2.3522,
            'estimated_delivery' => now()->addDays(3),
        ]);

        $this->createUpdates($s1, [
            ['pending', 'New York, NY', 'Shipment registered at origin hub', 40.7484, -73.9857, now()->subDays(4)],
            ['picked_up', 'New York, NY', 'Package picked up by courier', 40.7484, -73.9857, now()->subDays(3)->subHours(12)],
            ['in_transit', 'JFK International Airport', 'Package cleared customs, loaded on aircraft', 40.6413, -73.7781, now()->subDays(3)],
            ['in_transit', 'Reykjavik, Iceland', 'In transit - connecting flight', 64.1466, -21.9426, now()->subDays(2)],
            ['in_transit', 'Paris, France', 'Arrived at European distribution center', 48.8566, 2.3522, now()->subDays(1)],
        ]);

        // ── Shipment 2: Los Angeles → Tokyo (Out for Delivery) ──
        $s2 = Shipment::create([
            'user_id' => $customer->id,
            'tracking_number' => 'BLU-LA2TKY2',
            'sender_name' => 'John Doe',
            'sender_email' => 'john@example.com',
            'sender_phone' => '+1 (555) 123-4567',
            'sender_address' => '100 Universal City Plaza, Los Angeles, CA 90012',
            'receiver_name' => 'Yuki Tanaka',
            'receiver_email' => 'yuki@example.jp',
            'receiver_phone' => '+81 3-1234-5678',
            'receiver_address' => '1-1 Marunouchi, Chiyoda, Tokyo 100-0005, Japan',
            'package_description' => 'Documents - Legal contracts',
            'weight' => 0.50,
            'package_type' => 'document',
            'status' => 'out_for_delivery',
            'origin_lat' => 34.0522,
            'origin_lng' => -118.2437,
            'destination_lat' => 35.6762,
            'destination_lng' => 139.6503,
            'current_lat' => 35.6520,
            'current_lng' => 139.7447,
            'estimated_delivery' => now()->addDay(),
        ]);

        $this->createUpdates($s2, [
            ['pending', 'Los Angeles, CA', 'Shipment created', 34.0522, -118.2437, now()->subDays(5)],
            ['picked_up', 'Los Angeles, CA', 'Package collected', 34.0522, -118.2437, now()->subDays(4)],
            ['in_transit', 'LAX Airport', 'Departed Los Angeles', 33.9425, -118.4081, now()->subDays(4)->subHours(6)],
            ['in_transit', 'Honolulu, Hawaii', 'Refueling stop', 21.3069, -157.8583, now()->subDays(3)],
            ['in_transit', 'Narita Airport, Tokyo', 'Arrived in Japan, customs clearance', 35.7720, 140.3929, now()->subDays(2)],
            ['in_transit', 'Tokyo Distribution Center', 'Package sorted for local delivery', 35.6895, 139.6917, now()->subDays(1)],
            ['out_for_delivery', 'Chiyoda, Tokyo', 'Out for delivery with local courier', 35.6520, 139.7447, now()->subHours(3)],
        ]);

        // ── Shipment 3: Sydney → Dubai (Delivered) ──
        $s3 = Shipment::create([
            'user_id' => $customer->id,
            'tracking_number' => 'BLU-SYD2DXB',
            'sender_name' => 'John Doe',
            'sender_email' => 'john@example.com',
            'sender_phone' => '+1 (555) 123-4567',
            'sender_address' => '1 Macquarie Street, Sydney NSW 2000, Australia',
            'receiver_name' => 'Ahmed Al-Rashid',
            'receiver_email' => 'ahmed@example.ae',
            'receiver_phone' => '+971 4 123 4567',
            'receiver_address' => 'Sheikh Zayed Road, Dubai, UAE',
            'package_description' => 'Freight - Industrial equipment parts',
            'weight' => 45.00,
            'package_type' => 'freight',
            'status' => 'delivered',
            'origin_lat' => -33.8568,
            'origin_lng' => 151.2153,
            'destination_lat' => 25.2048,
            'destination_lng' => 55.2708,
            'current_lat' => 25.2048,
            'current_lng' => 55.2708,
            'estimated_delivery' => now()->subDays(1),
            'actual_delivery' => now()->subDays(1),
        ]);

        $this->createUpdates($s3, [
            ['pending', 'Sydney, Australia', 'Freight shipment registered', -33.8568, 151.2153, now()->subDays(10)],
            ['picked_up', 'Sydney Port', 'Freight collected and loaded', -33.8568, 151.2153, now()->subDays(9)],
            ['in_transit', 'Singapore', 'Container ship docked at Singapore port', 1.3521, 103.8198, now()->subDays(6)],
            ['in_transit', 'Mumbai, India', 'Transit through Indian Ocean', 19.0760, 72.8777, now()->subDays(4)],
            ['in_transit', 'Jebel Ali Port, Dubai', 'Arrived at destination port', 25.0657, 55.1713, now()->subDays(2)],
            ['out_for_delivery', 'Dubai, UAE', 'Cleared customs, out for final delivery', 25.1972, 55.2744, now()->subDays(1)->subHours(6)],
            ['delivered', 'Sheikh Zayed Road, Dubai', 'Package delivered successfully', 25.2048, 55.2708, now()->subDays(1)],
        ]);

        // ── Shipment 4: Berlin → São Paulo (Pending) ──
        Shipment::create([
            'user_id' => $customer->id,
            'tracking_number' => 'BLU-BER2SAO',
            'sender_name' => 'John Doe',
            'sender_email' => 'john@example.com',
            'sender_phone' => '+1 (555) 123-4567',
            'sender_address' => 'Alexanderplatz 1, 10178 Berlin, Germany',
            'receiver_name' => 'Maria Santos',
            'receiver_email' => 'maria@example.br',
            'receiver_phone' => '+55 11 1234-5678',
            'receiver_address' => 'Av. Paulista, 1578 - São Paulo, SP, Brazil',
            'package_description' => 'Personal items - Books and clothing',
            'weight' => 8.20,
            'package_type' => 'parcel',
            'status' => 'pending',
            'origin_lat' => 52.5200,
            'origin_lng' => 13.4050,
            'destination_lat' => -23.5505,
            'destination_lng' => -46.6333,
            'current_lat' => 52.5200,
            'current_lng' => 13.4050,
            'estimated_delivery' => now()->addDays(7),
        ]);

        ShipmentUpdate::create([
            'shipment_id' => 4,
            'status' => 'pending',
            'location_name' => 'Berlin, Germany',
            'description' => 'Shipment registered, awaiting pickup',
            'lat' => 52.5200,
            'lng' => 13.4050,
            'update_time' => now(),
        ]);

        $this->command->info('✅ Seeded: admin (admin@blueorientlogistics.org / password)');
        $this->command->info('✅ Seeded: customer (customer@example.com / password)');
        $this->command->info('✅ Seeded: 4 demo shipments with tracking updates');
    }

    private function createUpdates(Shipment $shipment, array $updates): void
    {
        foreach ($updates as $u) {
            ShipmentUpdate::create([
                'shipment_id' => $shipment->id,
                'status' => $u[0],
                'location_name' => $u[1],
                'description' => $u[2],
                'lat' => $u[3],
                'lng' => $u[4],
                'update_time' => $u[5],
            ]);
        }
    }
}
