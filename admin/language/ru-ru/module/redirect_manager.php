<?php
$version = 'v1.1';

//------------------------------------------------------------------------------
// Heading
//------------------------------------------------------------------------------
$_['heading_title']						= 'Управление редиректами';
$_['heading_welcome']					= '';
$_['help_first_time']					= '';

// Backup/Restore Settings
$_['button_backup_settings']			= 'Backup Settings';
$_['text_this_will_overwrite_your']		= 'This will overwrite your previous backup file. Continue?';
$_['text_backup_saved_to']				= 'Backup saved to your /system/logs/ folder on';
$_['text_view_backup']					= 'View Backup';
$_['text_download_backup_file']			= 'Download Backup File';

$_['button_restore_settings']			= 'Restore Settings';
$_['text_restore_from_your']			= 'Restore from your:';
$_['text_automatic_backup']				= '<b>Automatic Backup</b>, created when this page was loaded:';
$_['text_manual_backup']				= '<b>Manual Backup</b>, created when "Backup Settings" was clicked:';
$_['text_backup_file']					= '<b>Backup File:</b>';
$_['button_restore']					= 'Restore';
$_['text_this_will_overwrite_settings']	= 'This will overwrite all current settings. Continue?';
$_['text_restoring']					= 'Restoring...';
$_['error_invalid_file_data']			= 'Error: invalid file data';
$_['text_settings_restored']			= 'Settings restored successfully';

// Buttons
$_['button_tooltips_enabled']			= 'Tooltips Enabled';
$_['button_tooltips_disabled']			= 'Tooltips Disabled';

//------------------------------------------------------------------------------
// Settings
//------------------------------------------------------------------------------
$_['entry_status']						= 'Активация:';
$_['help_status']						= 'Надо включить, что заработал';

$_['entry_sorting']						= 'Сортировать:';
$_['help_sorting']						= 'Сортировать вывод списка.';

$_['entry_filter_from_url']				= 'Фильтр по начальному URL:';
$_['help_filter_from_url']				= 'from / от URL';

$_['entry_filter_to_url']				= 'Фильтр по конечному URL:';
$_['help_filter_to_url']				= 'from / от URL';

$_['entry_sort_and_filter']				= '';
$_['button_sort_and_filter']			= 'Сортировать';

//------------------------------------------------------------------------------
// Redirects
//------------------------------------------------------------------------------
$_['heading_redirects']					= 'Редиректы';
$_['button_reset_all']					= 'Сбросить статистику';
$_['help_reset_all']					= 'Reset the "Times Used" value of all redirects. This cannot be undone.';
$_['button_delete_all']					= 'Удалить все';
$_['help_delete_all']					= 'Удалить все. Это не получится отменить.';

$_['column_action']						= 'Действие';
$_['column_active']						= 'Активный';
$_['column_from_url']					= 'с URL';
$_['column_to_url']						= 'на URL';
$_['column_response_code']				= 'Код ответа';
$_['column_date_start']					= 'Дата от';
$_['column_date_end']					= 'Дата до';
$_['column_times_used']					= 'Использовали раз';

$_['text_moved_permanently']			= '301 Moved Permanently';
$_['text_found']						= '302 Found';
$_['text_temporary_redirect']			= '307 Temporary Redirect';

$_['help_table_active']					= 'Uncheck to temporarily disable the redirect';
$_['help_table_from_url']				= 'На слэши вначале и в конце можно не обращать внимания. Урл редиректится на тот же сайт, с которого был запрошен! Т.е. указывать напрямую http(s):// - не нужно.'; 
$_['help_table_to_url']					= 'На слэши вначале и в конце можно не обращать внимания. Урл редиректится на тот же сайт, с которого был запрошен! Т.е. указывать напрямую http(s):// - не нужно.'; 
$_['help_response_code']				= 'Код ответа';
$_['help_table_date_start']				= 'По дате - поля можно оставить пустыми, можно указать. Тогда будет редирект в зависимости от разрешенных дат';
$_['help_table_date_end']				= 'По дате - поля можно оставить пустыми, можно указать. Тогда будет редирект в зависимости от разрешенных дат';

$_['placeholder_date_format']			= 'YYYY-MM-DD';

$_['button_add_row']					= 'Добавить';

//------------------------------------------------------------------------------
// Standard Text
//------------------------------------------------------------------------------
$_['copyright']							= '<hr /><div class="text-center" style="margin: 15px">' . $_['heading_title'] . ' (' . $version . ') &copy; <a target="_blank" href="https://hobotix.com.ua">Hobotix 4 Eapteka</a></div>';

$_['standard_autosaving_enabled']		= 'Автосохранение вкл.';
$_['standard_confirm']					= 'Операцию нельзя отменить. Продолжить?';
$_['standard_error']					= '<strong>Error:</strong> You do not have permission to modify ' . $_['heading_title'] . '!';
$_['standard_warning']					= '<strong>Warning:</strong> The number of settings is close to your <code>max_input_vars</code> server value. You should enable auto-saving to avoid losing any data.';
$_['standard_please_wait']				= 'Please wait...';
$_['standard_saving']					= 'Сохраняю...';
$_['standard_saved']					= 'Сохранено!';
$_['standard_select']					= '--- Выберите ---';
$_['standard_success']					= 'Успешно!';

$_['standard_module']					= 'Модули';
$_['standard_shipping']					= 'Доставка';
$_['standard_payment']					= 'Платежи';
$_['standard_total']					= 'Итоги';
$_['standard_feed']						= 'Фиды';
?>