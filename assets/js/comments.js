let ul = document.getElementById('jp-cm')
function get() {
        let url = window.location.href
        $.ajax({
        url: 'https://www.nkuhjp.com/JP-Comment/controllers/get.php',
        type: 'post',
        headers: {
            Accept: 'application/json;charset=utf-8'
        },
        dataType: 'json',
        data: {
            url: url
        },
        success: (data) => {
            try {
                console.log('success')
            } catch(e) {
                console.log(e)
            }
            console.log(data)
            data = data['Content']
            for(let i = 0; i < data.length; ++i) {
                ul.appendChild(create(data[i]['headicon'], data[i]['nickname'], data[i]['date'],data[i]['content'], data[i]['site']))
            }
            document.getElementById('jp-count').innerText = data.length
        },
        error: (data) => {
            console.log('error')
            console.log(data)
        }
    })
}
function save() {
        let nickname = $('#jp-nickname').val()
        let site = $('#jp-site').val()
        if (site.substring(0, 4) !== 'http') {
            site = 'https://' + site
        }
        let content = $('#jp-content').val()
        let newDate = new Date()
        let date = newDate.toLocaleString()
        console.log('data is ' + date)
        let origin = window.location.origin
        let url = window.location.href
        if (nickname.trim() === '' || content.trim() === '') {
            return
        }
    $.ajax({
        url: 'https://www.nkuhjp.com/JP-Comment/controllers/save.php',
        type: 'post',
        headers: {
            Accept: 'application/json;charset=utf-8'
        },
        dataType: 'json',
        data: {
            nickname: nickname,
            content: content,
            site: site,
            origin: origin,
            url: url,
            datee: date
        },
        success: (data) => {
            try {
                console.log('success')
            } catch(e) {
                console.log(e)
            }
            console.log(data)
            data = data['Content']
            for(let i = 0; i < data.length; ++i) {
                ul.appendChild(create(data[i]['headicon'], data[i]['nickname'], data[i]['date'],data[i]['content'], data[i]['site']))
            }
            while(ul.firstChild) {
                ul.removeChild(ul.firstChild)
            }
            get()
        },
        error: (data) => {
            console.log('error')
            console.log(data)
        }
    })
    $('#jp-nickname').val('')
    $('#jp-site').val('')
    $('#jp-content').val('')
}
function create(headicon='', nickname='', date='', content='', url='') {
    let li = document.createElement('li')
    li.setAttribute('class', 'list-group-item')
    let top = document.createElement('div')
    top.setAttribute('class', 'jp-comment-top')
    let a = document.createElement('a')
    a.setAttribute('href', url)
    let img = document.createElement('img')
    img.setAttribute('src', headicon)
    img.setAttribute('class', 'jp-avator')
    let name = document.createElement('span')
    name.setAttribute('class', 'jp-name')
    name.innerText = nickname
    a.appendChild(img)
    a.appendChild(name)
    let dat = document.createElement('span')
    dat.setAttribute('class', 'jp-date')
    dat.innerText = date
    top.appendChild(a)
    top.appendChild(dat)
    let cnt = document.createElement('div')
    cnt.setAttribute('class', 'jp-content')
    cnt.innerText = content
    li.appendChild(top)
    li.appendChild(cnt)
    return li
}
document.getElementById('jp-smt').onclick = save
get();
