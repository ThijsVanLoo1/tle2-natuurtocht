<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Category;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Card::with('category', 'seasons');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('season')) {
            $query->whereHas('seasons', function (Builder $q) use ($request) {
                $q->where('seasons.id', $request->season);
            });
        }

        $cards = $query->get();
        $categories = Category::all();
        $seasons = Season::all();

        return view('admin.index', compact('cards', 'categories', 'seasons'));
    }

    public function edit(Card $card)
    {
        $categories = Category::all();
        $seasons = Season::all();
        return view('admin.cards.edit', compact('card', 'categories', 'seasons'));
    }

    public function update(Request $request, Card $card)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'seasons' => 'required|array',
            'seasons.*' => 'exists:seasons,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($card->image_url) {
                Storage::disk('public')->delete($card->image_url);
            }
            $path = $request->file('image')->store('cards', 'public');
            $validated['image_url'] = $path;
        }

        // Extract seasons to avoid updating it in the cards table
        $seasons = Arr::pull($validated, 'seasons');

        $card->update($validated);

        if ($seasons) {
            $card->seasons()->sync($seasons);
        }

        return redirect()->route('admin.index')->with('success', 'Card updated successfully.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'seasons' => 'required|array',
            'seasons.*' => 'exists:seasons,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cards', 'public');
            $validated['image_url'] = $path;
        }

        // Extract seasons to avoid inserting it into the cards table
        $seasons = Arr::pull($validated, 'seasons');

        $card = Card::create($validated);

        if ($seasons) {
            $card->seasons()->sync($seasons);
        }

        return redirect()->route('admin.index')->with('success', 'Card created successfully.');
    }

    public function create()
    {
        $categories = Category::all();
        $seasons = Season::all();
        return view('admin.cards.create', compact('categories', 'seasons'));
    }

    public function destroy(Card $card)
    {
        if ($card->image_url) {
            Storage::disk('public')->delete($card->image_url);
        }

        $card->delete();

        return redirect()->route('admin.index')->with('success', 'Card deleted successfully.');
    }
}
