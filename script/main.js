document.addEventListener("DOMContentLoaded", () => {
    const bookmarkButtons = document.querySelectorAll(".bookmark-btn");

    bookmarkButtons.forEach(button => {
        button.addEventListener("click", () => {
            const newsId = button.getAttribute("data-news-id");
            const icon = button.querySelector("ion-icon");
            const isBookmarked = icon.getAttribute("name") === "bookmark";

            fetch(isBookmarked ? "../db/remove_from_read_later.php" : "../db/add_to_read_later.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ news_id: newsId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else if (data.success) {
                        icon.setAttribute("name", isBookmarked ? "bookmark-outline" : "bookmark");
                    } else if (data.error) {
                        alert("Помилка: " + data.error);
                    }
                })
                .catch(err => console.error("Помилка:", err));
        });
    });
});
