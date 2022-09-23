<?php
// Heading
$_['heading_title']                      = 'Octemplates - Менеджер модификаторов';

// Button
$_['button_refresh']                     = 'Обновить кеш модификаторов';
$_['button_refresh_system_cache']        = 'Удалить кеш системы';
$_['button_clear']                       = 'Удалить кеш модификаторов';
$_['button_refresh_image_cache']         = 'Удалить кеш изображений';
$_['button_add']                         = 'Создать новый модификатор';
$_['button_delete_selected']             = 'Удалить выбранное';
$_['button_viewphpinfo']                 = 'Подробная информация';
$_['button_archive']                     = 'Переместить в архив';
$_['button_unarchive_selected']          = 'Восстановить в папку system';
$_['button_unarchive_installed']         = 'Восстановить в базу данных';

// Tab
$_['tab_system']                         = 'Из папки system';
$_['tab_modification']                   = 'Установленные';
$_['tab_archive']                        = 'Архив';
$_['tab_system_information']             = 'Тех. информация';

// Text
$_['text_list']                          = 'Список модификаторов';
$_['text_mod_type']                      = 'Поиск по автору модификатора:';
$_['text_mod_type_1']                    = 'Octemplates';
$_['text_filter_name']                   = 'Поиск по названию модификатора:';
$_['text_all_modificators']              = 'Все';
$_['text_enabled']                       = 'Включено';
$_['text_disabled']                      = 'Отключено';
$_['text_exist']                         = 'Есть';
$_['text_not_exist']                     = 'Нет';
$_['column_name']                        = 'Название модификатора';
$_['column_filename']                    = 'Название файла';
$_['column_author']                      = 'Автор';
$_['column_version']                     = 'Версия';
$_['column_status']                      = 'Статус';
$_['column_doubling']                    = 'Дубли';
$_['column_doubling_help']               = 'Проверка установлен ли модификатор стандартным способом через Установку дополнений.';
$_['column_date_modified']               = 'Последние изминения';
$_['column_date_added']                  = 'Установлен';
$_['column_action']                      = 'Действие';
$_['button_enable']                      = 'Включить';
$_['button_disable']                     = 'Отключить';
$_['button_delete']                      = 'Удалить';
$_['button_edite']                       = 'Редактировать';
$_['button_save']                        = 'Сохранить';
$_['button_save_and_stay']               = 'Сохранить и продолжить';
$_['button_cancel']                      = 'Закрыть';
$_['button_clear_filter']                = 'Сброс';
$_['button_filter']                      = 'Фильтр';
$_['text_modification_name']             = 'Введите название модификатора:';
$_['text_install_mod_type']              = 'Как установить модификатор?';
$_['text_install_mod_to_system']         = 'Поместить в папку system';
$_['text_install_mod_to_archive']        = 'Поместить в архив';
$_['text_install_mod_by_default']        = 'Установить стандартным способом';
$_['text_php_version']                   = 'Версия PHP:';
$_['text_curl']                          = 'Статус cURL:';
$_['text_ioncube']                       = 'Статус ionCube Loader:';
$_['text_phpinfo']                       = 'PHP Info:';
$_['tab_archive_faq']                    = 'Архив - это резервное хранилище (папка) на вашем сервере, для хранения удаленных ранее или принудительно перемещенных сюда модификатор. Модификаторы, которые находятся здесь никак не влияют на работу вашего сайта.';

// Success
$_['success_delete']                     = 'Удаление выполнено успешно. Кеш модификаторов автоматически очищен!';
$_['success_disabled']                   = 'Модификатор успешно отключен. Кеш модификаторов автоматически очищен!';
$_['success_enabled']                    = 'Модификатор успешно включен. Кеш модификаторов автоматически очищен!';
$_['success_edite']                      = 'Модификатор успешно отредактирован. Кеш модификаторов автоматически обновлен!';
$_['success_refresh']                    = 'Кеш модификаторов успешно обновлен!';
$_['success_refresh_system_cache']       = 'Кеш системы успешно очищен!';
$_['success_refresh_image_cache']        = 'Кеш картинок успешно очищен!';
$_['success_clear']                      = 'Кеш модификаторов успешно очищен!';
$_['success_added_system']               = 'Модификатор успешно создан. Кеш модификаторов автоматически очищен!';
$_['success_added_installed']            = 'Модификатор успешно установлен. Кеш модификаторов автоматически очищен!';
$_['success_archive']                    = 'Модификатор успешно заархивирован. Кеш модификаторов автоматически очищен!';
$_['success_unarchive']                  = 'Модификатор успешно восстановлен. Кеш модификаторов автоматически очищен!';

// Error
$_['error_permission']                   = 'У вас нет доступа к списку загруженного материала!';
$_['error_delete_selected']              = 'Выберите модификаторы для удаления!';
$_['error_failed_load_file']             = 'Ошибка в загрузке модификатора!';
$_['error_modification_name']            = 'Введите название модификатора!';
$_['error_modification_code']            = 'Введите код модификатора!';
$_['error_modification_exist_system']    = 'Модификатор с таким названием уже существует в папке system!';
$_['error_modification_exist_archive']   = 'Модификатор с таким названием уже существует в архиве!';
$_['error_modification_exist_installed'] = 'Модификатор с таким названием уже установлен!';
$_['error_check_empty_fields']           = 'Обнаружена ошибка при создании модификатора. Проверьте заполнили лы вы все поля!';
$_['error_modification_structure']       = 'Нарушена структура модификатора или такой формат данных не корректный!';
$_['error_copy_to_archive']              = 'Ошибка при архивировании модификатора!';