import flatpickr from 'flatpickr';
import { Japanese } from "flatpickr/dist/l10n/ja.js"
import 'flatpickr/dist/flatpickr.css';

document.addEventListener('DOMContentLoaded', function () {

    flatpickr("#reservation_date", {
        enableTime: false,
        dateFormat: "Y-m-d",
        locale: Japanese,
        minDate: new Date().fp_incr(1), // 翌日以降を選択可能
        disable: [
            function(date) {
                const dayOfWeek = date.getDay();
                return closedDays.includes(dayOfWeek); // ここで定休日を無効化
            }
        ],
    });
});