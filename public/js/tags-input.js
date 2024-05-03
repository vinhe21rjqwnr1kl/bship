const input_tag = document.querySelector('.input-tag');
const tagsInput = document.getElementById('tags_input');
const tags_length = document.querySelector('.tags-length');
let tags_list = [];

document.getElementById('input-tag-search').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
    }
});

input_tag.addEventListener("keyup", (e) => {
    const val = input_tag.value;
    if (e.key == "Enter") {
        if (tags_list.some(e => e.text == val)) return alert("Duplicate tags!!!");
        if (val == "") return;
        const tags = val.split(',').map(e => e.trim()).filter(e => e !== "")
        for (let tag of tags) {
            tags_list.push({
                id: Math.random().toString(10).substring(2, 10),
                text: tag,
            })
        }
        input_tag.value = "";
        RenderTags();
    }
});

function RenderTags() {
    tagsInput.value = JSON.stringify(tags_list.map(tag => tag.text));
    const wrapper_tags = document.querySelector(".wrapper-tags");
    let cache = "";
    document.querySelectorAll(".item-tag").forEach(e => e.remove());
    cache = "";
    tags_list.forEach(e => {
        cache = `<div class="item-tag">
                    <span>${e.text}</span>
                    <button type="button" data-id="${e.id}" class="btn-rm-tag">
                        <i class="fas fa-times fa-sli"></i>
                    </button>
                </div>`;
        wrapper_tags.insertAdjacentHTML('afterbegin', cache);
        HandleRmTags();
    });
    tags_length.textContent = `${tags_list.length} Thẻ`;
}

function HandleRmTags() {
    const btns = document.querySelectorAll(".btn-rm-tag");
    btns.forEach(e => {
        e.onclick = function () {
            const data_id = Number(e.getAttribute("data-id"));
            tags_list = tags_list.filter(t => t.id != data_id);
            RenderTags();
        }
    })
}

function updateTagsAfterReload(tags) {
    for (let tag of tags) {
        tags_list.push({
            id: Math.random().toString(10).substring(2, 10),
            text: tag,
        })
    }
    input_tag.value = "";
    RenderTags();
}

window.addEventListener('load', function() {
    const tagsInput = document.getElementById('tags_input');
    let arr = JSON.parse(tagsInput.value);
    updateTagsAfterReload(arr)
});


