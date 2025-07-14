<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Boutique;

class CheckCurrentBoutique
{
    public function handle(Request $request, Closure $next)
    {
        $currentBoutiqueId = $request->header('currentboutique');

        if (!$currentBoutiqueId) {
            return response()->json(['message' => 'Aucune boutique sélectionnée'], 403);
        }

        $boutique = Boutique::find($currentBoutiqueId);
        if (!$boutique) {
            return response()->json(['message' => 'Boutique sélectionnée introuvable'], 403);
        }

        // Partage la boutique trouvée avec le contrôleur (accessible via $request->attributes)
        $request->attributes->set('currentBoutique', $boutique);

        return $next($request);
    }
}
