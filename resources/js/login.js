async function send(method, url, data = null) {
  if (method === "POST") {
    return await fetch(url, {
      method: "POST",
      body: data,
    });
  }

  return (await fetch(url)).json();
}
const testWS = (target) => /\s/.test(target);
const note = document.querySelector("#note");
const submiter = document.querySelector('input[type="submit"]')
const login = document.querySelector("#loginForm");
const password = document.querySelectorAll("#password");

login.addEventListener("submit", async (e) => {
  e.preventDefault();
  const data = new FormData(e.target);
  let user = data.get("username");

  if (!testWS(user)) {
    try {
      const req = await send("POST", "/login", data);
      const res = await req.json();
      console.log(res);

      if (res.say === "Success") {
        window.location.href = `/@${user}`;
      } else {
        note.textContent = res.say;
        password.value = "";
      }
    } catch (err) {
      console.log(err);
      note.textContent = "Login Failed";
      password.value = "";
    }
    return;
  }
  note.textContent = "Login Failed";
});


