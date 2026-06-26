import os

base_dir = r'c:\Users\HP\blue'

# We will search and replace key text strings inside the blade files.
replacements = {
    # ── home.blade.php ──
    'Trusted by 50,000+ businesses worldwide': "{{ __('Trusted by 50,000+ businesses worldwide') }}",
    'Ship Anywhere,<br>': "{{ __('Ship Anywhere') }},<br>",
    'Track Everything': "{{ __('Track Everything') }}",
    'Global shipping solutions with real-time GPS tracking, live animated maps, and seamless logistics management. Your package, our priority.': "{{ __('Global shipping solutions with real-time GPS tracking, live animated maps, and seamless logistics management. Your package, our priority.') }}",
    'Send a Package': "{{ __('Send a Package') }}",
    'Track Shipment': "{{ __('Track Shipment') }}",
    'Enter tracking number (e.g. BLU-XXXXXXXX)': "{{ __('Enter tracking number (e.g. BLU-XXXXXXXX)') }}",
    'Track': "{{ __('Track') }}",
    'Our <span class="text-gradient">Services</span>': "{{ __('Our') }} <span class=\"text-gradient\">{{ __('Services') }}</span>",
    'Comprehensive shipping solutions tailored to your needs, from documents to heavy freight.': "{{ __('Comprehensive shipping solutions tailored to your needs, from documents to heavy freight.') }}",
    'Express Delivery': "{{ __('Express Delivery') }}",
    'Next-day and same-day delivery for urgent shipments. Lightning-fast with full tracking visibility.': "{{ __('Next-day and same-day delivery for urgent shipments. Lightning-fast with full tracking visibility.') }}",
    'Learn more': "{{ __('Learn more') }}",
    'Standard Shipping': "{{ __('Standard Shipping') }}",
    'Cost-effective shipping for non-urgent deliveries. Reliable 3-7 day delivery with real-time updates.': "{{ __('Cost-effective shipping for non-urgent deliveries. Reliable 3-7 day delivery with real-time updates.') }}",
    'International Shipping': "{{ __('International Shipping') }}",
    'Seamless cross-border logistics with customs handling. Ship to 120+ countries worldwide.': "{{ __('Seamless cross-border logistics with customs handling. Ship to 120+ countries worldwide.') }}",
    'How It <span class="text-gradient">Works</span>': "{{ __('How It') }} <span class=\"text-gradient\">{{ __('Works') }}</span>",
    'Three simple steps to ship your packages anywhere in the world.': "{{ __('Three simple steps to ship your packages anywhere in the world.') }}",
    'Create Shipment': "{{ __('Create Shipment') }}",
    'Fill in sender and receiver details, select package type, and submit your shipment request.': "{{ __('Fill in sender and receiver details, select package type, and submit your shipment request.') }}",
    'We Pick Up & Ship': "{{ __('We Pick Up & Ship') }}",
    'Our team picks up your package and routes it through our optimized global logistics network.': "{{ __('Our team picks up your package and routes it through our optimized global logistics network.') }}",
    'Track & Receive': "{{ __('Track & Receive') }}",
    'Track your package on our live map with animated GPS tracking until it arrives at the destination.': "{{ __('Track your package on our live map with animated GPS tracking until it arrives at the destination.') }}",
    'Ready to <span class="text-gradient">Ship</span>?': "{{ __('Ready to') }} <span class=\"text-gradient\">{{ __('Ship') }}</span>?",
    'Join thousands of businesses and individuals who trust Blue Orient Logistics for fast, reliable, and trackable deliveries worldwide.': "{{ __('Join thousands of businesses and individuals who trust Blue Orient Logistics for fast, reliable, and trackable deliveries worldwide.') }}",
    "Get Started — It's Free": "{{ __('Get Started — It\'s Free') }}",
    'View Pricing': "{{ __('View Pricing') }}",

    # ── about.blade.php ──
    'About Us': "{{ __('About Us') }}",
    'Connecting the World,<br>': "{{ __('Connecting the World') }},<br>",
    'One Package at a Time': "{{ __('One Package at a Time') }}",
    "Founded with a vision to make global shipping accessible, transparent, and reliable for everyone. We've grown from a small courier service to a worldwide logistics platform trusted by thousands.": "{{ __('Founded with a vision to make global shipping accessible, transparent, and reliable for everyone. We\'ve grown from a small courier service to a worldwide logistics platform trusted by thousands.') }}",
    'Our Mission': "{{ __('Our Mission') }}",
    'To provide fast, reliable, and affordable shipping solutions that connect businesses and people across the globe with complete transparency.': "{{ __('To provide fast, reliable, and affordable shipping solutions that connect businesses and people across the globe with complete transparency.') }}",
    'Our Vision': "{{ __('Our Vision') }}",
    "To become the world's most trusted logistics platform, where every shipment is trackable, every delivery is on time, and every customer feels valued.": "{{ __('To become the world\'s most trusted logistics platform, where every shipment is trackable, every delivery is on time, and every customer feels valued.') }}",
    'Our Values': "{{ __('Our Values') }}",
    'Integrity, innovation, and customer-first thinking drive everything we do. We believe in building trust through consistent, exceptional service.': "{{ __('Integrity, innovation, and customer-first thinking drive everything we do. We believe in building trust through consistent, exceptional service.') }}",
    'Our <span class="text-gradient">Story</span>': "{{ __('Our') }} <span class=\"text-gradient\">{{ __('Story') }}</span>",
    'Blue Orient Logistics started in 2018 with a simple idea: shipping should be transparent. Our founders, frustrated by the lack of real-time visibility in traditional logistics, set out to build something better.': "{{ __('Blue Orient Logistics started in 2018 with a simple idea: shipping should be transparent. Our founders, frustrated by the lack of real-time visibility in traditional logistics, set out to build something better.') }}",
    'What began as a small courier service in New York has grown into a global logistics platform serving over 120 countries. Our proprietary tracking technology gives customers unprecedented visibility into their shipments, right down to the exact location on a live map.': "{{ __('What began as a small courier service in New York has grown into a global logistics platform serving over 120 countries. Our proprietary tracking technology gives customers unprecedented visibility into their shipments, right down to the exact location on a live map.') }}",
    'Today, we process over 50,000 shipments and continue to innovate with AI-powered route optimization, predictive delivery estimates, and our industry-leading live tracking dashboard.': "{{ __('Today, we process over 50,000 shipments and continue to innovate with AI-powered route optimization, predictive delivery estimates, and our industry-leading live tracking dashboard.') }}",
    'Founded': "{{ __('Founded') }}",
    'Team Members': "{{ __('Team Members') }}",
    'Global Offices': "{{ __('Global Offices') }}",
    'Customer Rating': "{{ __('Customer Rating') }}",
    'Want to Join Our <span class="text-gradient">Network</span>?': "{{ __('Want to Join Our') }} <span class=\"text-gradient\">{{ __('Network') }}</span>?",
    "Whether you're a business looking for reliable shipping or an individual sending a package, we're here for you.": "{{ __('Whether you\'re a business looking for reliable shipping or an individual sending a package, we\'re here for you.') }}",
    'Start Shipping Today': "{{ __('Start Shipping Today') }}",
}

for root, dirs, files in os.walk(os.path.join(base_dir, 'resources', 'views')):
    for file in files:
        if file.endswith('.blade.php'):
            file_path = os.path.join(root, file)
            with open(file_path, 'r', encoding='utf-8') as f:
                content = f.read()
                
            new_content = content
            modified = False
            for old, new in replacements.items():
                if old in new_content:
                    # Only do replacement if it's not already wrapped
                    if f"{{ __('{old}') }}" not in content and f"{{ __('{old}') }}" not in new_content:
                        new_content = new_content.replace(old, new)
                        modified = True
                        
            if modified:
                with open(file_path, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                print(f"Wrapped translations in: {file_path}")
