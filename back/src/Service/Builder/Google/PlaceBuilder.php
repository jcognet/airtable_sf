<?php
declare(strict_types=1);

namespace App\Service\Builder\Google;

use App\ValueObject\Google\Place;

class PlaceBuilder
{
    public function build(array $data): Place
    {
        $address = $data['address_components']['long_name']
            ?? $data['formatted_address']
            ?? $data['vicinity'];

        return new Place(
            name: $data['name'],
            address: $address,
            rating: $data['rating'] ?? null,
            ratingUserTotal: $data['user_ratings_total'] ?? null,
            openingHours: $data['opening_hours']['weekday_text'] ?? null,
            description: $data['editorial_summary']['overview'] ?? null,
            phoneNumber: $data['formatted_phone_number'] ?? null,
            googleUrl: $data['url'] ?? null,
            url: $data['website'] ?? null
        );
    }
}
