<?php  

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class XssValidator
{
	public function handle(Request $request, Closure $next)
	{
		$input = $request->all();
		
		array_walk_recursive($input, function(&$input) {
			if(!empty($input))
			{
				$input = strip_tags(str_replace(array("&lt;", "&gt;"), '', $input), '<span><p><a><b><i><u><strong><br><hr><table><tr><th><td><thead><tbody><tfoot><ul><ol><li><h1><h2><h3><h4><h5><h6><del><ins><sup><sub><pre><address><img><figure><embed><iframe><video><style><div><section><input><select><option><textarea><button><header><footer><form><label><nav><small><aside><blockquote><map><svg><rect><circle><ellipse><line><polyline><polygon><path><text><g><defs><filter><feGaussianBlur><feOffset><feBlend><stop><linearGradient><radialGradient><feColorMatrix><feComponentTransfer><feComposite><feConvolveMatrix><feDiffuseLighting><feDisplacementMap><feFlood><feImage><feMerge><feMorphology><feSpecularLighting><feTile><feTurbulence><feDistantLight><fePointLight><feSpotLight>');

			}
		});
		
		$request->merge($input);
		
		return $next($request);
	}
}
?>