<?php
if (!defined('APP_STARTED')) {
    exit('Доступ запрещён.');
}

function addEscape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function addLoadContacts(): array
{
    if (!file_exists(NB_DATA_FILE)) {
        return [];
    }

    $json = file_get_contents(NB_DATA_FILE);
    $contacts = json_decode($json, true);

    return is_array($contacts) ? $contacts : [];
}

function addSaveContacts(array $contacts): bool
{
    return file_put_contents(
        NB_DATA_FILE,
        json_encode(array_values($contacts), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
    ) !== false;
}

function addGetNextContactId(array $contacts): int
{
    $maxId = 0;

    foreach ($contacts as $contact) {
        if ($contact['id'] > $maxId) {
            $maxId = $contact['id'];
        }
    }

    return $maxId + 1;
}

function getAddPage(): string
{
    $message = '';
    $messageClass = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $contacts = addLoadContacts();

        $newContact = [
            'id' => addGetNextContactId($contacts),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'first_name' => trim($_POST['first_name'] ?? ''),
            'middle_name' => trim($_POST['middle_name'] ?? ''),
            'gender' => trim($_POST['gender'] ?? ''),
            'birth_date' => trim($_POST['birth_date'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'comment' => trim($_POST['comment'] ?? ''),
            'created_at' => time(),
        ];

        if (
            $newContact['last_name'] !== ''
            && $newContact['first_name'] !== ''
            && $newContact['birth_date'] !== ''
            && $newContact['phone'] !== ''
            && $newContact['email'] !== ''
        ) {
            $contacts[] = $newContact;

            if (addSaveContacts($contacts)) {
                $message = 'Запись добавлена';
                $messageClass = 'success';
            } else {
                $message = 'Ошибка: запись не добавлена';
                $messageClass = 'error';
            }
        } else {
            $message = 'Ошибка: запись не добавлена';
            $messageClass = 'error';
        }
    }

    $html = '<h2>Добавление записи</h2>';

    if ($message !== '') {
        $html .= '<p class="' . $messageClass . '">' . $message . '</p>';
    }

    $html .= '
        <form method="post" action="index.php?page=add">
            <label>Фамилия</label>
            <input type="text" name="last_name" required>

            <label>Имя</label>
            <input type="text" name="first_name" required>

            <label>Отчество</label>
            <input type="text" name="middle_name">

            <label>Пол</label>
            <select name="gender">
                <option value="Мужской">Мужской</option>
                <option value="Женский">Женский</option>
            </select>

            <label>Дата рождения</label>
            <input type="date" name="birth_date" required>

            <label>Телефон</label>
            <input type="text" name="phone" required>

            <label>Адрес</label>
            <input type="text" name="address">

            <label>E-mail</label>
            <input type="email" name="email" required>

            <label>Комментарий</label>
            <textarea name="comment" rows="4"></textarea>

            <button type="submit">Добавить запись</button>
        </form>
    ';

    return $html;
}