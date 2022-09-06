<?php

use Illuminate\Support\Str;

define("PAGELIST", "liste");
define("PAGECREATEFORM", "create");
define("PAGEEDITFORM", "edit");
define("DEFAULTPASSWORD", "password");

	function userFullName()
	{
		return Auth()->user()->nom." ".Auth()->user()->prenom;
	}

	function getRoleName(){
		$roleName = "";
		$i = 0;
		foreach (Auth()->user()->roles as $role) {
			$roleName .= $role->nom;
			//si la variable i < la taille de tableau
			if ($i < sizeof(Auth()->user()->roles) -1) {
				$roleName .= ",";
			}
			$i++;
		}
		return $roleName;
	}
	function contains($container,$contenu)
	{
		return Str::contains($container,$contenu);
	}

	function setMenuStyle($route,$classe)
	{
		$routeActuel = request()->route()->getName();
		if (contains($routeActuel,$route)) {
			return $classe;
		}
		return "";
	}

	function setMenuActive($route)
	{
		$routeActuel = request()->route()->getName();
		if ($routeActuel === $route) {
			return 'active';
		}
		return "";
	}