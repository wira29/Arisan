function formatDate(timestamp) {
    const date = new Date(timestamp);

    const months = [
    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    const day = date.getDate().toString().padStart(2, "0"); // 05
    const month = months[date.getMonth()]; // Maret
    const year = date.getFullYear(); // 2025

    const formattedDate = `${day} ${month} ${year}`;
    return formattedDate;
}