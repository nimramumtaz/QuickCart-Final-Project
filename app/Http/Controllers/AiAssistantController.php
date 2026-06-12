<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AiAssistantController extends Controller
{
    public function ask(Request $request)
    {
        $data = $request->validate(['message' => ['required', 'string', 'max:700']]);
        $products = Product::select('name', 'category', 'price', 'rating')->orderByDesc('rating')->take(18)->get();
        $context = $products->map(fn ($p) => "{$p->name} ({$p->category}) Rs.{$p->price}, rating {$p->rating}")->implode('; ');
        $prompt = "You are QuickCart AI shopping assistant for a Pakistani mega mall. Recommend products briefly, mention prices in PKR, and be friendly. Product catalog: {$context}. Customer asks: {$data['message']}";

        if (config('services.gemini.key')) {
            try {
                $response = Http::timeout(20)->post(
                    'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . config('services.gemini.key'),
                    ['contents' => [['parts' => [['text' => $prompt]]]]]
                );

                $answer = data_get($response->json(), 'candidates.0.content.parts.0.text');
                if ($answer) {
                    return response()->json(['answer' => $answer, 'source' => 'Gemini']);
                }
            } catch (\Throwable) {
                // Free fallback keeps the demo useful without an API key or internet.
            }
        }

        return response()->json([
            'answer' => $this->localAnswer($data['message']),
            'source' => 'Free local fallback',
        ]);
    }

    private function localAnswer(string $message): string
    {
        $term = Str::of($message)->lower();

        if ($term->contains(['delivery', 'deliver', 'shipping', 'ship'])) {
            return 'QuickCart offers free delivery above Rs.1,500. Below that, delivery is Rs.150. Faisalabad orders are prepared fastest, usually same-day or next-day in this demo project.';
        }

        if ($term->contains(['return', 'refund', 'exchange', 'back'])) {
            return 'For returns/refunds, use the Contact section and choose Return / Refund. Your message is saved in the Laravel admin dashboard so support can handle it.';
        }

        if ($term->contains(['payment', 'pay', 'cod', 'cash', 'easypaisa', 'jazzcash'])) {
            return 'Available payment options are Cash on Delivery, Easypaisa, JazzCash, and Bank Transfer. Cash on Delivery is selected by default for easy checkout.';
        }

        if ($term->contains(['contact', 'phone', 'email', 'support', 'help'])) {
            return 'You can contact QuickCart at 03194854924 or nimramumtaz29@gmail.com. Messages submitted from the contact form also appear in the admin dashboard.';
        }

        $categoryAliases = [
            'food' => ['food', 'burger', 'biryani', 'pizza', 'shake', 'sweet', 'kebab', 'karahi', 'eat'],
            'electronics' => ['electronics', 'tech', 'earbuds', 'watch', 'speaker', 'power bank', 'mouse', 'keyboard', 'webcam'],
            'beauty' => ['beauty', 'makeup', 'lipstick', 'serum', 'perfume', 'skin', 'sunscreen', 'cream'],
            'fashion' => ['fashion', 'dress', 'gown', 'jacket', 'blazer', 'jumpsuit'],
            'clothing' => ['clothing', 'shirt', 'jeans', 'hoodie', 'kurta', 'abaya'],
            'footwear' => ['footwear', 'shoes', 'sneakers', 'loafers', 'khussa', 'sandals'],
            'books' => ['book', 'books', 'study', 'poetry', 'exam', 'cooking', 'habits'],
            'sports' => ['sports', 'football', 'cricket', 'yoga', 'dumbbell', 'racket', 'fitness'],
            'home' => ['home', 'candle', 'mug', 'cushion', 'led', 'purifier'],
            'toys' => ['toys', 'kids', 'lego', 'car', 'teddy', 'ludo', 'drawing'],
            'grocery' => ['grocery', 'rice', 'oil', 'honey', 'dry fruit'],
            'pharmacy' => ['pharmacy', 'medicine', 'vitamin', 'thermometer', 'first aid'],
            'stationery' => ['stationery', 'notebook', 'sketch', 'pencil'],
            'pets' => ['pet', 'pets', 'dog', 'cat'],
            'automotive' => ['automotive', 'car mount', 'car perfume', 'vehicle'],
            'jewelry' => ['jewelry', 'bracelet', 'earrings', 'gold', 'silver'],
        ];

        $category = null;
        foreach ($categoryAliases as $cat => $words) {
            if ($term->contains($words)) {
                $category = $cat;
                break;
            }
        }

        $query = Product::query();
        if ($category) {
            $query->where('category', $category);
        } else {
            $keywords = collect(preg_split('/\s+/', preg_replace('/[^a-z0-9\s]/i', ' ', $term->toString())))
                ->filter(fn ($word) => strlen($word) > 3)
                ->take(5);

            if ($keywords->isNotEmpty()) {
                $query->where(function ($q) use ($keywords) {
                    foreach ($keywords as $word) {
                        $q->orWhere('name', 'like', "%{$word}%")
                            ->orWhere('description', 'like', "%{$word}%")
                            ->orWhere('category', 'like', "%{$word}%");
                    }
                });
            }
        }

        if ($term->contains(['cheap', 'low price', 'budget', 'under', 'affordable'])) {
            $query->orderBy('price');
            $tone = 'budget-friendly';
        } elseif ($term->contains(['gift', 'present', 'recommend'])) {
            $query->where('rating', '>=', 4.7)->orderByDesc('reviews');
            $tone = 'gift-worthy';
        } elseif ($term->contains(['sale', 'deal', 'discount', 'offer'])) {
            $query->whereIn('badge', ['sale', 'deal'])->orderBy('price');
            $tone = 'deal';
        } else {
            $query->orderByDesc('rating')->orderByDesc('reviews');
            $tone = 'best-rated';
        }

        $match = $query->take(3)->get();
        if ($match->isEmpty()) {
            $match = Product::orderByDesc('rating')->orderByDesc('reviews')->take(3)->get();
        }

        $items = $match->map(fn ($p) => "{$p->name} (Rs. " . number_format($p->price) . ', ' . ucfirst($p->category) . ')')->implode('; ');
        $categoryText = $category ? " in {$category}" : '';

        return "For your question, my {$tone}{$categoryText} picks are: {$items}. You can search the product name or open its category to add it to cart.";
    }
}
