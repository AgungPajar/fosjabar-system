<?php

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Menu;
use App\Models\User;
use App\Models\Module;
use App\Models\Setting;
use App\Models\LogSystem;
use App\Models\UserGroup;
use App\Models\OrderConfig;
use Illuminate\Support\Str;
use App\Models\ModuleAccess;
use Illuminate\Http\Request;
use App\Models\ProductConfig;
use App\Models\OrderStatusLog;
use Illuminate\Support\Facades\DB;
use App\Models\UserGroupPermission;

function asset_administrator($url)
{
	return asset('administrator/' . $url);
}

function asset_frontpage($url)
{
	return asset('frontpage/' . $url);
}

function asset_landing_page($url)
{
	return asset('landing_page/' . $url);
}

function upload_path($type = '', $file = '', $base_url = false)
{
	switch ($type) {
		case 'logo':
			$target_folder = 'settings';
			break;
		case 'favicon':
			$target_folder = 'settings';
		case 'setting':
			$target_folder = 'settings';
			break;
		case 'page':
			$target_folder = 'pages';
			break;
		default:
			$target_folder = '';
			break;
	}

	$path = Str::finish("assets/media/modules/{$target_folder}", '/') . $file;
	return $base_url ? asset($path) : $path;
}

function img_src($image = '', $img_type = '', $type = '')
{
	$file_notfound = '/assets/media/img/default/broken.png';
	$avatar_notfound = '/assets/media/img/default/avatar.png';

	if (empty($image)) {
        return $type === 'avatar' ? $avatar_notfound : $file_notfound;
    }
	if (filter_var($image, FILTER_VALIDATE_URL)) {
		return $image;
	} else {
		switch ($img_type) {
			case 'logo':
				$folder = '/settings/';
				break;
			case 'banners':
				$folder = '/banners/';
				break;
			case 'favicon':
				$folder = '/settings/';
			case 'setting':
				$folder = '/settings/';
				break;
			case 'page':
				$folder = '/pages/';
				break;
			default:
				$folder = '/';
				break;
		}
		$file = 'assets/media/modules' . $folder . $image;

		if ($image === true) {
			return url('media' . $folder);
		}

		if (file_exists($file) && !is_dir($file)) {
			return url($file);
		}

		if ($type === 'avatar') {
			return url($avatar_notfound);
		}

		return url($file_notfound);
	}
}

function createLog($module, $action, $data_id)
{
	$log['ip_address'] 	= request()->ip();
	$log['user_id'] 	= auth()->check() ? auth()->user()->id : 0;
	$log['module'] 		= $module;
	$log['action'] 		= $action;
	$log['data_id'] 	= $data_id;
	$log['created_at'] 	= date('Y-m-d H:i:s');
	LogSystem::create($log);
}

function createOrderStatusLog($order_id, $status, $comment = null)
{
	if ($status === 'waiting_for_payment') {
        $existingLog = OrderStatusLog::where('order_id', $order_id)
                                      ->where('order_status', $status)
                                      ->count();

        if ($existingLog > 2) {
            return;
        }
    }

	$statusLog['created_by'] 			= auth()->check() ? auth()->user()->id : null;
	$statusLog['order_id'] 				= $order_id;
	$statusLog['order_status'] 			= $status;
	$statusLog['comment'] 				= $comment;
	OrderStatusLog::create($statusLog);
}

function isAllowed($modul, $modul_akses)
{
	$data_user = User::find(auth()->check() ? auth()->user()->id : 0);
	if (!isset($data_user)) {
		return FALSE;
	}
	$grup_pengguna_id = $data_user->user_group_id;
	$permission = getPermissionGroup($grup_pengguna_id);
	if ($grup_pengguna_id == '' || $grup_pengguna_id == '0') {
		return TRUE;
	} else {
		if ($permission[$grup_pengguna_id][$modul][$modul_akses] == 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

function getDefaultPermission()
{
	$query = ModuleAccess::select(DB::raw("modules_access.*,user_group_permissions.user_group_id,user_group_permissions.status"))
		->leftJoin(
			DB::raw("user_group_permissions"),
			function ($join) {
				$join->on('user_group_permissions.module_access_id', '=', 'modules_access.id');
			}
		);
	$data_akses = $query->get();
	$data_grup_pengguna = UserGroup::all();
	$permission = array();
	foreach ($data_grup_pengguna as $val) {
		foreach ($data_akses as $row) {
			$permission[$val->id][$row->module_id][$row->id] = 0;
		}
	}
	return $permission;
}

function getPermissionGroup($user_group_id)
{
	$data_akses = ModuleAccess::select(DB::raw('modules.identifiers as module_identifiers,modules_access.*,user_group_permissions.user_group_id,user_group_permissions.status'))
		->leftJoin(
			DB::raw("user_group_permissions"),
			function ($join) use ($user_group_id) {
				$join->on('user_group_permissions.module_access_id', '=', 'modules_access.id')->where("user_group_permissions.user_group_id", "=", $user_group_id);
			}
		)
		->leftJoin(DB::raw("modules"), "modules.id", "=", "modules_access.module_id")
		->get();
	$permission = [];
	$index = 0;

	foreach ($data_akses as $row) {
		if ($row->status == "") {
			$status = 0;
		} else {
			$status = $row->status;
		}
		$permission[$user_group_id][$row->module_identifiers][$row->identifiers] = $status;
	}
	$index++;

	return $permission;
}

function getPermissionGroup2($x)
{
	$data_akses = ModuleAccess::select(DB::raw('modules.identifiers as module_identifiers,modules_access.*,user_group_permissions.user_group_id,user_group_permissions.status'))
		->leftJoin(
			DB::raw("user_group_permissions"),
			function ($join) use ($x) {
				$join->on('user_group_permissions.module_access_id', '=', 'modules_access.id')->where("user_group_permissions.user_group_id", "=", $x);
			}
		)
		->leftJoin(DB::raw("modules"), "modules.id", "=", "modules_access.module_id")
		->get();
	// dd($x);
	$permission = [];
	$index = 0;
	foreach ($data_akses as $row) {
		if ($row->status == "") {
			$status = 0;
		} else {
			$status = $row->status;
		}
		$permission[$x][$row->module_identifiers][$row->identifiers] = $status;
	}
	$index++;
	return $permission;
}

function getPermissionModuleGroup()
{
	$data_user = User::find(auth()->check() ? auth()->user()->id : 0);
	if (!isset($data_user)) {
		return [];
	}
	$grup_pengguna_id = $data_user->user_group_id;
	$data_akses = ModuleAccess::select(DB::raw('modules.identifiers as module_identifiers, COUNT(user_group_permissions.id) as permission_given'))
		->leftJoin(
			DB::raw("user_group_permissions"),
			function ($join) use ($grup_pengguna_id) {
				$join->on('user_group_permissions.module_access_id', '=', 'modules_access.id')->where("user_group_permissions.user_group_id", "=", $grup_pengguna_id)->where("user_group_permissions.status", 1);
			}
		)
		->leftJoin(DB::raw("modules"), "modules.id", "=", "modules_access.module_id")
		->groupBy("modules.id")
		->get();

	$permission = [];
	$index = 0;

	foreach ($data_akses as $row) {
		if ($row->permission_given > 0) {
			$status = TRUE;
		} else {
			$status = FALSE;
		}
		$permission[$row->module_identifiers] = $status;
	}
	$index++;

	return $permission;
}

function showModule($module)
{
	$data_user = User::find(auth()->user()->id);
	$grup_pengguna_id = $data_user->user_group_id;
	$permission_module = getPermissionModuleGroup();
	if ($grup_pengguna_id == '' || $grup_pengguna_id == '0') {
		return TRUE;
	} else {
		if (array_key_exists($module, $permission_module)) {
			return $permission_module[$module];
		} else {
			return FALSE;
		}
	}
}

function dataModule()
{
	$menu = Menu::all();
    $modul = Module::all();

    $data = [
        'menu' => $menu,
        'modul' => $modul,
    ];

    return $data;
}

function getPaymentDetail($billing)
{
	if (array_key_exists('payment_type', $billing)) {

		if ($billing['payment_type'] == 'credit_card') {
			echo '<br>' . ucwords(str_replace('_', ' ', $billing['payment_type'])) . ' - ' . strtoupper($billing['bank']);
		}

		if ($billing['payment_type'] == 'bank_transfer') {
			echo "<br>";
			if (array_key_exists("va_numbers", $billing)) {
				foreach ($billing['va_numbers'] as $row) {
					echo strtoupper($row->bank . (" Virtual Account") . ' <br> ' . $row->va_number);
				}
			}

			if (array_key_exists("permata_va_number", $billing)) {
				echo strtoupper("Permata" . (" Virtual Account") . ' <br> ' . $billing["permata_va_number"]);
			}
		}

		if ($billing['payment_type'] == 'echannel') {
			echo '<br>' . ("Mandiri Bill Payment") . '<br>';
			echo 'Biller Code : <strong>' . $billing["biller_code"] . '</strong><br>';
			echo 'Bill Key : <strong>' .  $billing["bill_key"] . '</strong><br>';
		}

		if ($billing['payment_type'] == 'cstore') {
			echo '<br>' . strtoupper(str_replace('_', ' ', $billing['payment_type'])) . '<br>';
			echo strtoupper($billing['store'] . ' - ' . $billing['payment_code']);
		}

		if ($billing['payment_type'] == 'qris') {
			echo "<br> QRIS";
			if (isset($billing['acquirer'])) {
				if ($billing['acquirer'] == "airpay shopee") {
					echo " - ShopeePay";
				}
				if ($billing['acquirer'] == "gopay") {
					echo " - GoPay";
				}
			}
		}

		if ($billing['payment_type'] == 'bca_klikpay') {
			echo '<br>' . ("BCA Klikpay");
		}

		if ($billing['payment_type'] == 'cimb_clicks') {
			echo '<br>' . ("OCTO Clicks - CIMB Niaga");
		}

		if ($billing['payment_type'] == 'danamon_online') {
			echo '<br>' . ("Danamon Online");
		}

		if ($billing['payment_type'] == 'akulaku') {
			echo '<br>' . ("Danamon Online");
		}

		if ($billing['payment_type'] == 'uob_ezpay') {
			echo '<br>' . ("UOB EZ Pay");
		}
	} else {
		echo 'Other';
	}
}

function getAuth(){
	return auth()->user() ? auth()->user() : auth()->guard('customers')->user();
}

function replaceFormat($data, $isDecimal = false)
{
    $clean = str_replace(['.', 'Rp', '%', 'off', ' '], '', $data);

    if ($isDecimal) {
        $clean = str_replace(',', '.', $clean);
    }

    return $clean;
}

function beautifyLabel($string) {
    $string = str_replace(['_', '-'], ' ', $string);
    return ucwords($string);
}

function generateUniqueSlug($model, $title, $slugField = 'slug', $ignoreId = null)
{
    $slug = Str::slug($title);
    $originalSlug = $slug;
    $i = 1;

    while (
        $model::where($slugField, $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
    ) {
        $slug = $originalSlug . '-' . $i++;
    }

    return $slug;
}

function limit_text($text, $limit = 100, $suffix = '...') {
    return mb_strimwidth(strip_tags($text), 0, $limit, $suffix);
}

function DataTagline(){
	$tags = Tag::orderBy('created_at', 'asc')->get();
	return $tags;
}

function carbonParse($date){
	return Carbon::parse($date);
}

function getStatusOrderClassColor($status) {
	return match($status) {
		'waiting_for_payment'     => 'light-warning',
		'waiting_for_confirmation'=> 'light-warning',
		'processed'               => 'light-primary',
		'processed_packing'       => 'light-primary',
		'shipping'                => 'light-info',
		'finished'                => 'light-success',
		'complain'                => 'light-danger',
		'failed'                  => 'light-dark',
		default                   => 'light-secondary',
	};
}

function shipmentLabel($number) {
    $suffix = 'th';
    if (!in_array(($number % 100), [11, 12, 13])) {
        switch ($number % 10) {
            case 1: $suffix = 'st'; break;
            case 2: $suffix = 'nd'; break;
            case 3: $suffix = 'rd'; break;
        }
    }
    return $number . $suffix;
}

function configs($name)
{
    static $configs = null;

    if ($configs === null) {
        $configs = Setting::pluck('value', 'name')->toArray();
    }

    return $configs[$name] ?? null;
}

function orderConfig($name)
{
    static $configs = null;

    if ($configs === null) {
        $configs = OrderConfig::pluck('value', 'name')->toArray();
    }

    return $configs[$name] ?? null;
}

function productConfig($name)
{
    static $configs = null;

    if ($configs === null) {
        $configs = ProductConfig::pluck('value', 'name')->toArray();
    }

    return $configs[$name] ?? null;
}

function scheduleDate(?string $relativeDay = 'now'): string
{
	$date = Carbon::now();

	if ($relativeDay && $relativeDay !== 'now') {
		$date = Carbon::now()->modify($relativeDay);
	}

	return $date->toDateString();
}
