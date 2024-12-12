String.prototype.isEmpty = function () {
  return this.length === 0 || !this.trim();
};

// For Post Modals => START
const btn_posting = document.querySelector(".btn-posting");
const modals = document.querySelector("#post-modals");
const resetMedia = document.querySelector("#reset-media");
// <= END

// For Edit Modals => START
const resetEditMedia = document.querySelector("#reset-edit-media");
const editModals = document.querySelector("#edit-modals");
const imgView = editModals.querySelector("#media-view-edit");
const bodyInput = editModals.querySelector("#body-post-edit");
const slugInput = editModals.querySelector("#slug-edit");
const oldMediaEdit = editModals.querySelector("#old-media-edit");
// <= END

const container = document.querySelector(".container");

function resetFile(target, view, old = false) {
  const resetTarget = document.querySelector(target);
  const output = document.querySelector(view);
  URL.revokeObjectURL(output.src);
  resetTarget.type = "text";
  resetTarget.type = "file";
  output.src = "#";
  if (old) {
    resetEditMedia.classList.toggle("none");
    oldMediaEdit.value = null
    return;
  }
  resetMedia.classList.toggle("none");
  return;
}

function editView(body, img, slug) {
  !img.isEmpty() ? (imgView.src = `img/uploads/${img}`, resetEditMedia.classList.toggle("none")) : (imgView.src = "#");
  bodyInput.value = body;
  oldMediaEdit.value = img;
  slugInput.value = slug;
  editModals.showModal();
}

async function sendEdit(target) {
  const submiter = target.querySelector('[type="submit"]')

  // console.log(submiter)
  // return false;
  const data = new FormData(target);
  submiter.toggleAttribute("disabled");

  // console.log(data);

  // return false;
  confirm("Are You Sure?");

  // form.
  try {
    const req = await send("POST", '/post/patch', data);
    const res = await req.json();
    if (res.status === "ok") {
      submiter.toggleAttribute("disabled");
      target.reset();
      window.location.href = "/";
    }
  } catch (err) {
    console.log(err);
  }
}

editModals.addEventListener("click", (event) => {
  const rect = editModals
    .querySelector(".modals-content")
    .getBoundingClientRect();
  const isInDialog =
    event.clientX >= rect.left &&
    event.clientX <= rect.right &&
    event.clientY >= rect.top &&
    event.clientY <= rect.bottom;

  if (!isInDialog) {
    editModals.close();
    imgView.src = "#";
    oldMediaEdit.value = null;
    bodyInput.value = null;
  }
});

btn_posting.addEventListener("click", () => {
  modals.showModal();
});

modals.addEventListener("click", (event) => {
  const rect = modals.querySelector(".modals-content").getBoundingClientRect();
  const isInDialog =
    event.clientX >= rect.left &&
    event.clientX <= rect.right &&
    event.clientY >= rect.top &&
    event.clientY <= rect.bottom;

  if (!isInDialog) {
    modals.close();
  }
});


// function resetFile(target, view, reseter = "#reset-media") {
//   const resetTarget = document.querySelector(target);
//   document.querySelector(reseter).classList.toggle("none");
//   const output = document.querySelector(view);
//   URL.revokeObjectURL(output.src);
//   output.src = "#";
//   resetTarget.type = "text";
//   resetTarget.type = "file";

//   return;
// }
function back(index) {
  window.history.go(-index);
}

async function send(method, url, data = null) {
  if (method === "POST") {
    return await fetch(url, {
      method: "POST",
      body: data,
    });
  }

  return (await fetch(url)).json();
}

async function saveProfile(url, session) {
  const form = document.querySelector("#optionForm");
  let data = new FormData(form);
  data.append("session", session);

  try {
    const res = await send("POST", url, data);
    console.log(res);
    alert("Berhasil Mengganti Profile");
    window.location.href = `/@${session}`;
  } catch (err) {
    alert("Gagal Mengedit Profile");
    console.log(err);
  }
}

async function deletePost(url, slug, target) {
  if (confirm("Are You Sure Delete This?")) {
    const destroyData = new FormData();
    destroyData.append("slug", slug);

    try {
      const req = await send("POST", url, destroyData);
      const res = await req.json();
      alert(res.status);
      document.querySelector(target).remove();
    } catch (err) {
      alert("Gagal menghapus");
    }
  }
}

function WillUpload(target, result, reseter = "#reset-media") {
  const output = document.querySelector(result);
  output.src = URL.createObjectURL(target.files[0]);
  document.querySelector(reseter).classList.toggle("none");
}

async function follow(url, followed, session, target) {
  target.toggleAttribute("disabled");
  // target.textContent = "wait..."

  let data = new FormData();
  data.append("followed", followed);
  data.append("follower", session);
  try {
    const req = await send("POST", url, data);
    const res = await req.json();
    // console.log(res)
    target.textContent = res.status;
    target.classList.toggle("following");
    target.toggleAttribute("disabled");
  } catch (err) {
    console.log(err);
    target.toggleAttribute("disabled");
  }
}

async function sendPost(url, target) {
  const form = document.querySelector("#postForm");
  const data = new FormData(form);
  target.toggleAttribute("disabled");

  console.log(data);

  // return false;
  confirm("Are You Sure?");

  // form.
  try {
    const req = await send("POST", url, data);
    const res = await req.text();
    if (res === "Ok") {
      target.toggleAttribute("disabled");
      form.reset();
      window.location.href = "/";
    }
  } catch (err) {
    console.log(err);
  }
}
async function sendReply(target, reply) {
  // return false
  const form = document.querySelector("#replyForm");
  const data = new FormData(form);
  data.append("reply", reply);
  target.toggleAttribute("disabled");
  console.log(data);
  try {
    const req = await send("POST", "/reply/create", data);
    const res = await req.text();
    if (res === "Ok") {
      target.toggleAttribute("disabled");
      form.reset();
      // window.location.href = window.location.href;
      window.location.reload();
    }

    target.toggleAttribute("disabled");
  } catch (err) {
    console.log(err);
    target.toggleAttribute("disabled");
  }
}

async function sendLike(url, session, owner, slug, target) {
  target.toggleAttribute("disabled");
  const targetSi = target.previousElementSibling;
  let data = new FormData();
  data.append("fan", session);
  data.append("owner", owner);
  data.append("slug", slug);

  try {
    const req = await send("POST", url, data);
    const res = await req.text();
    targetSi.textContent = eval(`${targetSi.textContent} ${res}`);
    console.log(res);
    await setTimeout(() => target.toggleAttribute("disabled"), 2000);
  } catch (err) {
    console.log(err);
    target.toggleAttribute("disabled");
  }
}

async function sendSave(url, session, owner, slug, target) {
  target.toggleAttribute("disabled");
  let data = new FormData();
  data.append("saver", session);
  data.append("owner", owner);
  data.append("slug", slug);

  try {
    const req = await send("POST", url, data);
    await setTimeout(() => target.toggleAttribute("disabled"), 2000);
  } catch (err) {
    console.log(err);
    target.toggleAttribute("disabled");
  }
}

function grow(target) {
  target.style.height = "auto";
  target.style.height = target.scrollHeight + "px";
  // console.log(target.scrollHeight)
}
//     await fetch(url, {
//       method: "POST",
//       body: destroyData,
//     })
//       .then((res) => res.json())
//       .then((res) => {
//         console.log(res);
//         document.querySelector(target).remove();
//       })
//       .catch((err) => console.log(err));
//   }
