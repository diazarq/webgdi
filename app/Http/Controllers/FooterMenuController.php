<?php

namespace App\Http\Controllers;

use App\Models\FooterMenu;
use Illuminate\Http\Request;

class FooterMenuController extends Controller
{
    public function index()
    {
        $quickLinks = FooterMenu::where('category', 'quick_link')->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
        $programLinks = FooterMenu::where('category', 'program_link')->orderBy('order', 'asc')->orderBy('id', 'asc')->get();

        return view('menu.footer-menu', [
            'pageTitle' => 'Kelola Menu Footer',
            'active' => ['FooterMenuActive' => 'active'],
            'quickLinks' => $quickLinks,
            'programLinks' => $programLinks,
        ]);
    }

    public function saveLink(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'category' => 'required|in:quick_link,program_link',
        ]);

        $id = $request->input('id');
        $category = $request->input('category', 'quick_link');
        $data = [
            'title' => $request->title,
            'url' => $request->url,
            'category' => $category,
            'order' => $request->input('order', 0),
            'status' => $request->input('status', 'A'),
        ];

        if ($id) {
            FooterMenu::where('id', $id)->update($data);
            $msg = 'Link footer berhasil diperbarui!';
        } else {
            if (empty($data['order'])) {
                $maxOrder = FooterMenu::where('category', $category)->max('order') ?? 0;
                $data['order'] = $maxOrder + 1;
            }
            FooterMenu::create($data);
            $msg = 'Link footer baru berhasil ditambahkan!';
        }

        return redirect()->back()->with('success', $msg);
    }

    public function deleteLink($id)
    {
        FooterMenu::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Link footer berhasil dihapus!');
    }
}
