<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function about()
    {
        $title = 'About Us';
        $content = "You must change this. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Odio aenean sed adipiscing diam donec adipiscing. Donec pretium vulputate sapien nec. Dignissim suspendisse in est ante in nibh mauris. Habitasse platea dictumst vestibulum rhoncus est pellentesque elit ullamcorper. Bibendum enim facilisis gravida neque convallis. Nec dui nunc mattis enim ut. Molestie nunc non blandit massa. Aenean pharetra magna ac placerat vestibulum lectus mauris ultrices. Dictumst vestibulum rhoncus est pellentesque elit. Tristique sollicitudin nibh sit amet commodo nulla facilisi nullam. Consequat semper viverra nam libero justo laoreet. Habitant morbi tristique senectus et. Et ligula ullamcorper malesuada proin libero nunc. At in tellus integer feugiat scelerisque varius morbi enim nunc. Sagittis nisl rhoncus mattis rhoncus urna neque viverra justo. Justo laoreet sit amet cursus sit. Posuere urna nec tincidunt praesent semper feugiat nibh sed.";
        return view('pages.index', compact('title', 'content'));
    }

    public function policy()
    {
        $title = 'Policy';
        $content = "You must change this.  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Odio aenean sed adipiscing diam donec adipiscing. Donec pretium vulputate sapien nec. Dignissim suspendisse in est ante in nibh mauris. Habitasse platea dictumst vestibulum rhoncus est pellentesque elit ullamcorper. Bibendum enim facilisis gravida neque convallis. Nec dui nunc mattis enim ut. Molestie nunc non blandit massa. Aenean pharetra magna ac placerat vestibulum lectus mauris ultrices. Dictumst vestibulum rhoncus est pellentesque elit. Tristique sollicitudin nibh sit amet commodo nulla facilisi nullam. Consequat semper viverra nam libero justo laoreet. Habitant morbi tristique senectus et. Et ligula ullamcorper malesuada proin libero nunc. At in tellus integer feugiat scelerisque varius morbi enim nunc. Sagittis nisl rhoncus mattis rhoncus urna neque viverra justo. Justo laoreet sit amet cursus sit. Posuere urna nec tincidunt praesent semper feugiat nibh sed.";
        return view('pages.index', compact('title', 'content'));
    }

    public function contact()
    {
        $title = 'Contact';
        $content = "You must change this.  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Odio aenean sed adipiscing diam donec adipiscing. Donec pretium vulputate sapien nec. Dignissim suspendisse in est ante in nibh mauris. Habitasse platea dictumst vestibulum rhoncus est pellentesque elit ullamcorper. Bibendum enim facilisis gravida neque convallis. Nec dui nunc mattis enim ut. Molestie nunc non blandit massa. Aenean pharetra magna ac placerat vestibulum lectus mauris ultrices. Dictumst vestibulum rhoncus est pellentesque elit. Tristique sollicitudin nibh sit amet commodo nulla facilisi nullam. Consequat semper viverra nam libero justo laoreet. Habitant morbi tristique senectus et. Et ligula ullamcorper malesuada proin libero nunc. At in tellus integer feugiat scelerisque varius morbi enim nunc. Sagittis nisl rhoncus mattis rhoncus urna neque viverra justo. Justo laoreet sit amet cursus sit. Posuere urna nec tincidunt praesent semper feugiat nibh sed.";
        return view('pages.index', compact('title', 'content'));
    }

}
