<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SettingRequest;
use App\Models\TagCategory;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index() {
        return inertia('Settings', [
            'tagCategories' => TagCategory::select(['id AS value', 'name AS label'])
                ->orderBy('name')
                ->get(),
            'settings' => Setting::select(['name', 'value'])
                ->get()
                ->mapWithKeys(function ($setting) {
                    return [
                        $setting->name => $setting->value
                    ];
                }),
        ]);
    }

    public function update(SettingRequest $request) {
        Setting::where('name', 'search_page_dropdown_tag_category_id')
            ->update(['value' => $request->search_page_dropdown_tag_category_id]);

        return redirect()->route('settings')->with([
            'message' => 'Settings successfully updated', 
            'status' => 'success'
        ]);
    }
}
