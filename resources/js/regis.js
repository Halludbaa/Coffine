const reset = () => password.forEach((element) => (element.value = ""));
const noteForPass = (msg) =>
  note_pass.forEach((element) => (element.textContent = msg));
const testWS = (target) =>
  /[A-Z\s@\+\-=\&\*\(\)\%\!\#\^\`\~\|\\\[\]\{\}\:\;\<\>\,\'\"\.]/.test(target);
async function send(method, url, data = null) {
  if (method === "POST") {
    return await fetch(url, {
      method: "POST",
      body: data,
    });
  }

  return (await fetch(url)).json();
}
//Declariton of DOM
const regis = document.querySelector("#regForm");
const note_pass = document.querySelectorAll(".note-pass");
const note_user = document.querySelector(".note-user");
const submiter = document.querySelector('input[type="submit"]');
const password = document.querySelectorAll("#password");

regis.addEventListener("submit", async (e) => {
  e.preventDefault();
  const data = new FormData(e.target);
  const username = data.get("username");
  submiter.toggleAttribute("disabled");

  if (!testWS(username)) {
    try {
      const req = await send("POST", "/register", data);
      const res = await req.json();
      console.log(res);

      if (res.msg === "success") {
        window.location.href = `/`;
      } else {
        if (res.for === "username") {
          note_user.textContent = res.msg;
          noteForPass(" ");
        }
        if (res.for === "password") {
          noteForPass(res.msg);
          note_user.textContent = "";
        }
        reset();
        submiter.toggleAttribute("disabled");
      }
    } catch (err) {
      submiter.toggleAttribute("disabled");
      console.log(err);
      reset();
    }
  } else {
    note_user.textContent =
      "username not able to special character and whitespace";
    reset();
    submiter.toggleAttribute("disabled");
  }
});
