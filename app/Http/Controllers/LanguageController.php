<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    protected function getLangFile($lang)
    {
        return resource_path("lang/{$lang}/message.php");
    }

    public function index($lang)
    {
        $langFile = $this->getLangFile($lang);
        $messages = File::exists($langFile) ? include($langFile) : [];
        return view('admin.languages.index', compact('messages', 'lang'));
    }

    public function edit($lang, $key)
    {
        $langFile = $this->getLangFile($lang);
        $messages = File::exists($langFile) ? include($langFile) : [];
        $value = $messages[$key] ?? '';

        return view('admin.languages.edit', compact('key', 'value', 'lang'));
    }

    public function update(Request $request, $lang, $key)
    {
        $newKey = $request->input('key');
        $value = $request->input('value');

        $langFile = $this->getLangFile($lang);
        $messages = File::exists($langFile) ? include($langFile) : [];
        unset($messages[$key]);
        $messages[$newKey] = $value;

        $this->saveToFile($messages, $langFile);

        return redirect()->route('languages.index', $lang)->with('success', 'Message updated successfully.');
    }

    private function saveToFile($messages, $langFile)
    {
        $content = "<?php\n\nreturn " . var_export($messages, true) . ";\n";
        File::put($langFile, $content);
    }

    // public function create($lang)
    // {
    //     return view('admin.languages.create', compact('lang'));
    // }

    // public function store(Request $request, $lang)
    // {
    //     $key = $request->input('key');
    //     $value = $request->input('value');

    //     $langFile = $this->getLangFile($lang);
    //     $messages = File::exists($langFile) ? include($langFile) : [];
    //     $messages[$key] = $value;

    //     $this->saveToFile($messages, $langFile);

    //     return redirect()->route('languages.index', $lang)->with('success', 'Message added successfully.');
    // }
    // public function destroy($lang, $key)
    // {
    //     $langFile = $this->getLangFile($lang);
    //     $messages = File::exists($langFile) ? include($langFile) : [];
    //     unset($messages[$key]);

    //     $this->saveToFile($messages, $langFile);

    //     return redirect()->route('languages.index', $lang)->with('success', 'Message deleted successfully.');
    // }

    public function setlocal($lang) {
        if (in_array($lang, ['en', 'pt', 'ar', 'es', 'fr'])) {
            App::setLocale($lang);
            Session::put('locale', $lang);

            $setting = Setting::find(1);
            $setting->lang_code = $lang;
            if($lang == "ar"){
                $setting->is_rtl = '1';
            }else{

                $setting->is_rtl = '0';
            }
            $setting->save();
        }
        return back();
    }


}
