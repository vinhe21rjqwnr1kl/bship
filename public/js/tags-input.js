'use strict';


const input_tag = document.querySelector('.input-tag');
const btnChoose = document.querySelector('.btn-choose');
const tagsInput = document.getElementById('tags_input');
const tags_length = document.querySelector('.tags-length');
let tags_list = [];
var inputTagSearch = document.getElementById('input-tag-search');

if (inputTagSearch) {
    inputTagSearch.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });
}

// if (input_tag) {
//     input_tag.addEventListener("keyup", (e) => {
//         const val = input_tag.value;
        // if (e.key == "Enter") {
        //     if (tags_list.some(e => e.text == val)) return alert("Duplicate tags!!!");
        //     if (val == "") return;
        //     const tags = val.split(';').map(e => e.trim()).filter(e => e !== "")
        //     for (let tag of tags) {
        //         tags_list.push({
        //             id: Math.random().toString(10).substring(2, 10),
        //             text: tag,
        //         })
        //     }
        //     input_tag.value = "";
        //     RenderTags();
        // }
//     });
// }

btnChoose.addEventListener('click', (e) => {
    const val = input_tag.value;
        if (tags_list.some(e => e.text == val)) return alert("Duplicate tags!!!");
        if (val == "") return;
        const tags = val.split(';').map(e => e.trim()).filter(e => e !== "")
        for (let tag of tags) {
            tags_list.push({
                id: Math.random().toString(10).substring(2, 10),
                text: tag,
            })
        }
        input_tag.value = "";
        RenderTags();
})

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

if (tagsInput && tagsInput.value) {
    window.addEventListener('load', function () {
        const tagsInput = document.getElementById('tags_input').value;
        if (tagsInput !== null && tagsInput !== '') {
            let arr = JSON.parse(tagsInput);
            updateTagsAfterReload(arr)
        }
    });
}


function removeVietnameseTones(str) {
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
    str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
    str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
    str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
    str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
    str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
    str = str.replace(/Đ/g, "D");
    str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, ""); // Huyền, sắc, hỏi, ngã, nặng
    str = str.replace(/\u02C6|\u0306|\u031B/g, ""); // Â, Ê, Ă, Ơ, Ư
    return str;
}


fetch(jsonUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        $(document).ready(function () {
            let currentIndex = -1;

            $('#input-tag-search').on('keyup', function (e) {

                if (e.key === 'ArrowDown' || e.key === 'ArrowUp' || e.key === 'Enter') {
                    return; // Bỏ qua các phím điều hướng và Enter trong sự kiện keyup
                }

                let query = $(this).val().toLowerCase().trim();
                let searchTerm = removeVietnameseTones(query);
                let parts = searchTerm.split(',');

                let results = '';
                if (parts.length === 1) {
                    $.each(data, function (key, city) {
                        if (removeVietnameseTones(city.name.toLowerCase()).includes(parts[0].trim())) {
                            results += `<div class="suggestion-item" data-level="city" data-code="${key}">${city.name}</div>`;
                        }
                    });
                } else if (parts.length === 2) {
                    let cityName = parts[0].trim();
                    let cityCode = null;
                    $.each(data, function (key, city) {
                        if (removeVietnameseTones(city.name.toLowerCase()) === cityName) {
                            cityCode = key;
                        }
                    });

                    if (cityCode && data[cityCode]['quan-huyen']) {
                        let districtSearchTerm = parts[1].trim();
                        $.each(data[cityCode]['quan-huyen'], function (key, district) {
                            if (removeVietnameseTones(district.name.toLowerCase()).includes(districtSearchTerm)) {
                                results += `<div class="suggestion-item" data-level="district" data-code="${key}">${district.name}</div>`;
                            }
                        });
                    }
                } else if (parts.length === 3) {
                    let cityName = parts[0].trim();
                    let districtName = parts[1].trim();
                    let cityCode = null;
                    let districtCode = null;

                    $.each(data, function (key, city) {
                        if (removeVietnameseTones(city.name.toLowerCase()) === cityName) {
                            cityCode = key;
                        }
                    });

                    if (cityCode && data[cityCode]['quan-huyen']) {
                        $.each(data[cityCode]['quan-huyen'], function (key, district) {
                            if (removeVietnameseTones(district.name.toLowerCase()) === districtName) {
                                districtCode = key;
                            }
                        });
                    }

                    if (cityCode && districtCode && data[cityCode]['quan-huyen'][districtCode]['xa-phuong']) {
                        let wardSearchTerm = parts[2].trim();
                        $.each(data[cityCode]['quan-huyen'][districtCode]['xa-phuong'], function (key, ward) {
                            if (removeVietnameseTones(ward.name.toLowerCase()).includes(wardSearchTerm)) {
                                results += `<div class="suggestion-item" data-level="ward" data-code="${key}">${ward.name}</div>`;
                            }
                        });
                    }
                }

                $('#search-results').html(results);
                currentIndex = -1;

                $('.suggestion-item').on('click', function () {
                    let level = $(this).data('level');
                    let code = $(this).data('code');
                    let text = $(this).text();

                    let currentValue = $('#input-tag-search').val();
                    let parts = currentValue.split(',');
                    if (level === 'city') {
                        $('#input-tag-search').val(text);
                    } else if (level === 'district') {
                        parts[1] = text;
                        $('#input-tag-search').val(parts.join(', '));
                    } else if (level === 'ward') {
                        parts[2] = text;
                        $('#input-tag-search').val(parts.join(', '));
                    }

                    $('#search-results').empty();
                });
            });

            $('#input-tag-search').on('keydown', function (e) {
                const items = $('#search-results .suggestion-item');

                var code = (e.keyCode ? e.keyCode : e.which);
                if (e.which === 38 || e.which === 40) {
                    $(this).focusout();
                }

                if (e.key === 'ArrowDown') {
                    $(this).focusout();
                    e.preventDefault();
                    currentIndex = (currentIndex + 1) % items.length;
                    items.removeClass('active');
                    items.eq(currentIndex).addClass('active');
                    items.eq(currentIndex)[0].scrollIntoView({block: 'nearest'}); // Đảm bảo mục được cuộn vào vùng nhìn thấy

                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    currentIndex = (currentIndex - 1 + items.length) % items.length;
                    items.removeClass('active');
                    items.eq(currentIndex).addClass('active');
                    items.eq(currentIndex)[0].scrollIntoView({block: 'nearest'}); // Đảm bảo mục được cuộn vào vùng nhìn thấy

                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (currentIndex >= 0 && currentIndex < items.length) {
                        items.eq(currentIndex).click();
                    }
                }
            });

            // Ẩn phần kết quả tìm kiếm khi bấm ra ngoài
            $(document).on('click', function (e) {
                if (!$(e.target).closest('.wrapper-tags').length) {
                    $('#search-results').empty();
                }
            });

            // Ngăn chặn việc ẩn phần kết quả khi bấm vào input hoặc phần kết quả
            $('#input-tag-search, #search-results').on('click', function (e) {
                e.stopPropagation();
            });

        });
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });

