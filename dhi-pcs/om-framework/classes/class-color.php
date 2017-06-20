<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

class omfw_Color {
	
	public static function filter_color($color) {
		$color=apply_filters('omfw_color_filter', $color);
		return $color;
	}
	
	public static function srgb2rgb($rgba) {
		$rgba=preg_replace('/\s/', '', $rgba);
		if(preg_match('#rgb\(([0-9]+),([0-9]+),([0-9]+)\)#',$rgba,$m)) {
			return array($m[1], $m[2], $m[3]);
		} else {
			return false;
		}
	}
	
	public static function srgba2rgba($rgba) {
		$rgba=preg_replace('/\s/', '', $rgba);
		if(preg_match('#rgba\(([0-9]+),([0-9]+),([0-9]+),([0-9\.]+)\)#',$rgba,$m)) {
			return array($m[1], $m[2], $m[3], $m[4]);
		} else {
			return false;
		}
	}
	
	public static function hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);
		
		if (strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		}
		else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		
		return array($r, $g, $b);
	}
	
	public static function rgb2hex($rgb) {
		$hex = str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
		$hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
		$hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);
	
		return $hex;
	}
	
	public static function rgb2hsl($rgb) {
	  $r = $rgb[0] / 255;
	  $g = $rgb[1] / 255;
	  $b = $rgb[2] / 255;
	
	  $max = max($r, $g, $b);
	  $min = min($r, $g, $b);
	
	  $l = ($max + $min) / 2;
	
	  if ($max == $min) {
	      $h = $s = 0;
	  } else {
	      $d = $max - $min;
	      $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);
	      switch($max){
	          case $r: $h = ($g - $b) / $d + ($g < $b ? 6 : 0); break;
	          case $g: $h = ($b - $r) / $d + 2; break;
	          case $b: $h = ($r - $g) / $d + 4; break;
	      }
	      $h /= 6;
	  }
	
	  return array($h, $s, $l);
	}
	
	public static function hsl2rgb($hsl) {
		$h = $hsl[0];
		$s = $hsl[1];
		$l = $hsl[2];
	
		if ($s == 0){
			$r = $g = $b = $l;
		}
		else {
			$q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
			$p = 2 * $l - $q;
			$r = self::hue2rgb($p, $q, $h + 1/3);
			$g = self::hue2rgb($p, $q, $h);
			$b = self::hue2rgb($p, $q, $h - 1/3);
		}
	
		return array(round($r * 255), round($g * 255), round($b * 255));
	}
	
	public static function rgb2hsv ($rgb) {
	   $HSL = array();
	
	   $var_R = ($rgb[0] / 255);
	   $var_G = ($rgb[1] / 255);
	   $var_B = ($rgb[2] / 255);
	
	   $var_Min = min($var_R, $var_G, $var_B);
	   $var_Max = max($var_R, $var_G, $var_B);
	   $del_Max = $var_Max - $var_Min;
	
	   $V = $var_Max;
	
	   if ($del_Max == 0) {
	      $H = 0;
	      $S = 0;
	   } else {
	      $S = $del_Max / $var_Max;
	
	      $del_R = ( ( ( $var_Max - $var_R ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
	      $del_G = ( ( ( $var_Max - $var_G ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
	      $del_B = ( ( ( $var_Max - $var_B ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
	
	      if      ($var_R == $var_Max) $H = $del_B - $del_G;
	      else if ($var_G == $var_Max) $H = ( 1 / 3 ) + $del_R - $del_B;
	      else if ($var_B == $var_Max) $H = ( 2 / 3 ) + $del_G - $del_R;
	
	      if ($H<0) $H++;
	      if ($H>1) $H--;
	   }
	
	   return array($H, $S, $V);
	}
	
	public static function hsv2rgb($hsv){
		$dS = $hsv[1];
		$dV = $hsv[2];
		$dC = $dV*$dS;
		$dH = $hsv[0] * 6;
		$dT = $dH;
		while($dT >= 2.0) $dT -= 2.0;
		$dX = $dC*(1-abs($dT-1));
		switch(floor($dH)) {
			case 0:
				$dR = $dC; $dG = $dX; $dB = 0.0; break;
			case 1:
				$dR = $dX; $dG = $dC; $dB = 0.0; break;
			case 2:
				$dR = 0.0; $dG = $dC; $dB = $dX; break;
			case 3:
				$dR = 0.0; $dG = $dX; $dB = $dC; break;
			case 4:
				$dR = $dX; $dG = 0.0; $dB = $dC; break;
			case 5:
				$dR = $dC; $dG = 0.0; $dB = $dX; break;
			default:
				$dR = 0.0; $dG = 0.0; $dB = 0.0; break;
		}
		$dM  = $dV - $dC;
		$dR += $dM; $dG += $dM; $dB += $dM;
		$dR *= 255; $dG *= 255; $dB *= 255;
		return array(round($dR), round($dG), round($dB));
	}
	
	public static function hue2rgb($p, $q, $t){
		if ($t < 0) $t += 1;
		if ($t > 1) $t -= 1;
		if ($t < 1/6) return $p + ($q - $p) * 6 * $t;
		if ($t < 1/2) return $q;
		if ($t < 2/3) return $p + ($q - $p) * (2/3 - $t) * 6;
		return $p;
	}
	
	public static function parse2rgba($color) {
		$rgba=array(0,0,0,1);
		
		if(is_array($color)) {
			$n=count($color);
			if($n >= 4) {
				$rgba=array_slice($color,0,4);
			} elseif($n == 3) {
				$color[3]=1;
				$rgba=$color;
			}
		} else {
			$color=strtolower(trim($color));
			if(substr($color,0,1) == '#') {
				$rgba=self::hex2rgb($color);
			} elseif(substr($color,0,4) == 'rgba') {
				$rgba=self::srgba2rgba($color);
			} elseif(substr($color,0,3) == 'rgb') {
				$rgba=self::srgb2rgb($color);
			}
		}
		
		return $rgba;
	}
	
	public static function lightness($color, $k) {
		$rgba=self::parse2rgba($color);
		if(!$rgba)
			return $color;
		$hsl=self::rgb2hsl($rgba);
		$hsl[2]+=$k;
		if($hsl[2] < 0) {
			$hsl[2]=0;
		} elseif($hsl[2] > 1) {
			$hsl[2]=1;
		}
		$rgba_=self::hsl2rgb($hsl);
		if(isset($rgba[3])) {
			return 'rgba('.$rgba_[0].','.$rgba_[1].','.$rgba_[2].','.$rgba[3].')';
		} else {
			return 'rgb('.$rgba_[0].','.$rgba_[1].','.$rgba_[2].')';
		}
	}
	
	public static function brightness($color, $k) {
		$rgba=self::parse2rgba($color);
		if(!$rgba)
			return $color;

		$hsv=self::rgb2hsv($rgba);
		$hsv[2]+=$k;
		if($hsv[2] < 0) {
			$hsv[2]=0;
		} elseif($hsv[2] > 1) {
			$hsv[2]=1;
		}
		$rgba_=self::hsv2rgb($hsv);
		if(isset($rgba[3])) {
			return 'rgba('.$rgba_[0].','.$rgba_[1].','.$rgba_[2].','.$rgba[3].')';
		} else {
			return 'rgb('.$rgba_[0].','.$rgba_[1].','.$rgba_[2].')';
		}
	}
	
	public static function rgba2string($rgba) {
		if(isset($rgba[3])) {
			return 'rgba('.$rgba[0].','.$rgba[1].','.$rgba[2].','.$rgba[3].')';
		} else {
			return 'rgb('.$rgba[0].','.$rgba[1].','.$rgba[2].')';
		}
	}

}