document.addEventListener('DOMContentLoaded', () => {

    const timerEl = document.getElementById('exam-timer');

    if (!timerEl) return;

    let remaining = parseInt(timerEl.dataset.remaining, 10);

    const tick = () => {

        // ⛔ WAKTU HABIS → FORCE SUBMIT
        if (remaining <= 0) {
            window.location.href =
                '/exam/' + window.EXAM_SESSION_ID + '/submit/force';
            return;
        }

        const minutes = Math.floor(remaining / 60);
        const seconds = remaining % 60;

        timerEl.textContent =
            String(minutes).padStart(2, '0') + ':' +
            String(seconds).padStart(2, '0');

        remaining--;
    };

    tick();
    setInterval(tick, 1000);
});



const autosaveUrl = document.querySelector('meta[name="autosave-url"]').content;
const csrfToken  = document.querySelector('meta[name="csrf-token"]').content;

let autosaveTimer = null;
let lastPayload   = null;

// Hitung waktu di soal (simple)
let questionStartTime = Date.now();

function autosave(optionId, questionId, isFlagged = false) {
    const timeSpent = Math.floor((Date.now() - questionStartTime) / 1000);

    const payload = {
        question_id: questionId,
        option_id: optionId,
        time_spent: timeSpent,
        is_flagged: isFlagged,
    };

    // Jangan kirim kalau payload sama
    if (JSON.stringify(payload) === JSON.stringify(lastPayload)) {
        return;
    }

    lastPayload = payload;

    fetch(autosaveUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify(payload),
    }).catch(() => {
        // gagal autosave → diamkan (tidak ganggu user)
    });
}

// Event: pilih jawaban
document.querySelectorAll('input[name="option"]').forEach(input => {
    input.addEventListener('change', e => {
        autosave(e.target.value, e.target.dataset.questionId);
    });
});

// Interval autosave (20 detik)
autosaveTimer = setInterval(() => {
    const checked = document.querySelector('input[name="option"]:checked');
    if (checked) {
        autosave(checked.value, checked.dataset.questionId);
    }
}, 20000);

const flagBtn = document.getElementById('btn-flag');

if (flagBtn) {
    let flagged = flagBtn.classList.contains('active');
    const questionId = flagBtn.dataset.questionId;

    flagBtn.addEventListener('click', () => {
        flagged = !flagged;
        flagBtn.classList.toggle('active');

        const checked = document.querySelector('input[name="option"]:checked');

        autosave(
            checked ? checked.value : null,
            questionId,
            flagged
        );
    });
}
