<?php

namespace App\Http\Controllers;

class DisplayParrotsController extends Controller
{
	public function display()
	{
		for ($i = 1; $i <= (\App\Zooname::count()); $i++) {
			$parrotsTable[\App\Zooname::find($i)->prefecture->prefecturename][\App\Zooname::find($i)->zooname] = \App\Zooname::find($i)->parrots->sortby('parrotname_id');
		}

		$zoonamesTable = \App\Zooname::with('prefecture')->get();
		$prefecturesTable = \App\Prefecture::get();
		$parrotnamesTable = \App\Parrotname::orderBy('parrotname', 'asc')->get();
		$overviews = \App\Overview::get();

		return view('zoo', compact("parrotsTable", "zoonamesTable", "prefecturesTable", "parrotnamesTable", "overviews"));
	}
}
