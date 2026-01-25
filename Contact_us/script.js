fetch('send_mail.php', { method: 'POST', body: new FormData(form) })
  .then(res => res.json())
  .then(json => {
    responseMsg.textContent = json.message;
    responseMsg.style.color = json.success ? 'green' : 'red';
    if (json.success) form.reset();
  });



document.getElementById("contactForm").addEventListener("submit", function(event) {
  event.preventDefault();

  const formData = new FormData(this);
  const responseMsg = document.getElementById("responseMsg");

  fetch("send_mail.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.text())
  .then(data => {
    responseMsg.textContent = data;
    responseMsg.style.color = data.includes("success") ? "green" : "red";
    if (data.includes("success")) this.reset();
  })
  .catch(() => {
    responseMsg.textContent = "❌ Something went wrong. Please try again.";
    responseMsg.style.color = "red";
  });
});
