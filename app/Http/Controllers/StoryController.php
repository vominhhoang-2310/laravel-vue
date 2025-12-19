<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    public function index(): Response
    {
        $stories = Story::orderByDesc('created_at')
            ->get()
            ->map(function (Story $story) {
                $publicDisk = Storage::disk('public');

                return [
                    'id' => $story->id,
                    'title' => $story->title,
                    'author' => $story->author,
                    'category' => $story->category,
                    'pdf_link' => $story->pdf_link,
                    'pdf_url' => $story->pdf_link ? $publicDisk->url($story->pdf_link) : null,
                    'description' => $story->description,
                    'published_year' => $story->published_year,
                    'thumbnail' => $story->thumbnail,
                    'thumbnail_url' => $story->thumbnail ? $publicDisk->url($story->thumbnail) : null,
                ];
            });

        return Inertia::render('Stories', [
            'stories' => $stories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateStory($request);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        if ($request->hasFile('pdf_link')) {
            $data['pdf_link'] = $request->file('pdf_link')->store('pdfs', 'public');
        }

        Story::create($data);

        return redirect()
            ->route('stories')
            ->with('success', __('stories.statuses.added'));
    }

    public function update(Request $request, Story $story): RedirectResponse
    {
        $data = $this->validateStory($request, true);

        if ($request->hasFile('thumbnail')) {
            $this->deleteThumbnail($story->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        } else {
            unset($data['thumbnail']);
        }

        if ($request->hasFile('pdf_link')) {
            $this->deletePdf($story->pdf_link);
            $data['pdf_link'] = $request->file('pdf_link')->store('pdfs', 'public');
        } else {
            unset($data['pdf_link']);
        }

        $story->update($data);

        return redirect()
            ->route('stories')
            ->with('success', __('stories.statuses.updated'));
    }

    public function destroy(Story $story): RedirectResponse
    {
        $this->deletePdf($story->pdf_link);
        $this->deleteThumbnail($story->thumbnail);
        $story->delete();

        return redirect()
            ->route('stories')
            ->with('success', __('stories.statuses.removed'));
    }

    private function validateStory(Request $request, bool $isUpdate = false): array
    {
        $maxYear = (int) date('Y') + 1;

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255', 'in:Animals,Life,Spaces'],
            'pdf_link' => [$isUpdate ? 'nullable' : 'required', 'file', 'mimes:pdf', 'max:30720'],
            'description' => ['nullable', 'string'],
            'published_year' => ['required', 'integer', 'min:0', 'max:' . $maxYear],
            'thumbnail' => [$isUpdate ? 'nullable' : 'required', 'image', 'max:10000'],
        ]);
    }

    private function deleteThumbnail(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }

    private function deletePdf(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
