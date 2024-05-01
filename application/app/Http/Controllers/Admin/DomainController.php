<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\DomainVerifcation;
use App\Http\Controllers\Controller;

class DomainController extends Controller
{
    public function getPending()
    {
        $pageTitle = 'Pending Domain';
        $pendings = DomainVerifcation::with('publisher')->where('status',2)->latest()->paginate(getPaginate());
        return view('admin.domain.pending',compact('pendings','pageTitle'));
    }

    public function approve(Request $request)
    {
       $approve =  DomainVerifcation::findOrFail($request->id);
       $approve->status = 1;
       $approve->save();
       $notify[]=['success','Domain Has been Approved'];
       return back()->withNotify($notify);
    }


    public function delete(Request $request)
    {
       $domain =  DomainVerifcation::findOrFail($request->id);

       $domain->delete();
       $notify[]=['success','Domain Has been Deleted'];
       return back()->withNotify($notify);
    }

    public function getApproved()
    {
        $pageTitle = 'Approved Domain';
        $approves = DomainVerifcation::with('publisher')->where('status',1)->latest()->paginate(getPaginate());
        return view('admin.domain.approved',compact('approves','pageTitle'));
    }

    public function unApprove(Request $request)
    {
       $unapprove =  DomainVerifcation::findOrFail($request->id);
       $unapprove->status = 2;
       $unapprove->save();
       $notify[]=['success','Domain Has been unapproved'];
       return back()->withNotify($notify);
    }
}
