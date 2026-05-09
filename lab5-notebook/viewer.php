<?php
if (!defined('APP_STARTED')) {
    exit('Доступ запрещён.');
}

function viewerEscape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function viewerLoadContacts(): array
{
    if (!file_exists(NB_DATA_FILE)) {
        return [];
    }

    $json = file_get_contents(NB_DATA_FILE);
    $contacts = json_decode($json, true);

    return is_array($contacts) ? $contacts : [];
}

function getViewer(string $sort, int $page): string
{
    $contacts = viewerLoadContacts();

    if ($sort === 'last_name') {
        usort($contacts, function ($a, $b) {
            return [$a['last_name'], $a['first_name']] <=> [$b['last_name'], $b['first_name']];
        });
    } elseif ($sort === 'birth_date') {
        usort($contacts, function ($a, $b) {
            return $a['birth_date'] <=> $b['birth_date'];
        });
    } else {
        usort($contacts, function ($a, $b) {
            return $a['created_at'] <=> $b['created_at'];
        });

        $sort = 'created';
    }

    $itemsPerPage = 10;
    $totalContacts = count($contacts);
    $totalPages = max(1, ceil($totalContacts / $itemsPerPage));

    if ($page < 1) {
        $page = 1;
    }

    if ($page > $totalPages) {
        $page = $totalPages;
    }

    $offset = ($page - 1) * $itemsPerPage;
    $contactsPage = array_slice($contacts, $offset, $itemsPerPage);

    $html = '<h2>Записная книжка</h2>';

    if (empty($contactsPage)) {
        return $html . '<p class="empty">Записей пока нет.</p>';
    }

    $html .= '<div class="table-wrapper">';
    $html .= '<table>';
    $html .= '
        <tr>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Пол</th>
            <th>Дата рождения</th>
            <th>Телефон</th>
            <th>Адрес</th>
            <th>E-mail</th>
            <th>Комментарий</th>
        </tr>
    ';

    foreach ($contactsPage as $contact) {
        $html .= '<tr>';
        $html .= '<td>' . viewerEscape($contact['last_name']) . '</td>';
        $html .= '<td>' . viewerEscape($contact['first_name']) . '</td>';
        $html .= '<td>' . viewerEscape($contact['middle_name']) . '</td>';
        $html .= '<td>' . viewerEscape($contact['gender']) . '</td>';
        $html .= '<td>' . viewerEscape($contact['birth_date']) . '</td>';
        $html .= '<td>' . viewerEscape($contact['phone']) . '</td>';
        $html .= '<td>' . viewerEscape($contact['address']) . '</td>';
        $html .= '<td>' . viewerEscape($contact['email']) . '</td>';
        $html .= '<td>' . viewerEscape($contact['comment']) . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';
    $html .= '</div>';

    if ($totalPages > 1) {
        $html .= '<div class="pagination">';

        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = $i === $page ? 'active' : '';
            $html .= '<a class="' . $activeClass . '" href="index.php?page=view&sort=' . viewerEscape($sort) . '&p=' . $i . '">' . $i . '</a>';
        }

        $html .= '</div>';
    }

    return $html;
}