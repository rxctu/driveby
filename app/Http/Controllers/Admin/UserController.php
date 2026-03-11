<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%");
            });
        }

        if ($request->input('status') === 'active') {
            $query->where('is_active', true);
        } elseif ($request->input('status') === 'inactive') {
            $query->where('is_active', false);
        }

        if ($request->input('role') === 'admin') {
            $query->where('is_admin', true);
        }

        $users = $query->withCount('orders')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function toggleActive(User $user): RedirectResponse
    {
        if ($user->is_admin) {
            return back()->with('error', 'Impossible de desactiver un administrateur.');
        }

        DB::table('users')->where('id', $user->id)->update(['is_active' => ! $user->is_active]);

        $status = ! $user->is_active ? 'active' : 'desactive';

        return back()->with('success', "Compte de {$user->name} {$status}.");
    }

    public function sendPasswordReset(User $user): RedirectResponse
    {
        Password::sendResetLink(['email' => $user->email]);

        return back()->with('success', "Email de reinitialisation envoye a {$user->email}.");
    }

    /**
     * Update user trust level, verification, and admin notes.
     */
    public function updateTrust(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'trust_level' => 'required|integer|min:0|max:5',
            'is_verified' => 'sometimes|boolean',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        DB::table('users')->where('id', $user->id)->update([
            'trust_level' => $validated['trust_level'],
            'is_verified' => $request->boolean('is_verified'),
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        return back()->with('success', "Confiance de {$user->name} mise a jour.");
    }
}
