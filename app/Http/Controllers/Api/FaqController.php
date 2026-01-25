<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use App\Http\Resources\FaqResource;
use App\Http\Resources\FaqTreeResource;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

        $faqs = Faq::query()
            ->orderBy($sortField, $sortDirection)
            ->latest()
            ->get();

        return FaqResource::collection($faqs);
    }

    public function store(FaqRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        $faq = Faq::create($data);

        return new FaqResource($faq);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Faq $faq)
    {
        return new FaqResource($faq);
    }

    public function update(FaqRequest $request, Faq $faq)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;

        $faq->update($data);

        return new FaqResource($faq);
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return response()->noContent();
    }
}
