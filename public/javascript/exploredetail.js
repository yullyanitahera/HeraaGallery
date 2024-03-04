var segmentTerakhir = window.location.href.split('/').pop();

$.ajax({
    url: window.location.origin +'/explore-detail/'+ segmentTerakhir +'/getdatadetail',
    type: "GET",
    dataType: "JSON",
    success: function(res){
        console.log(res)
        $('#fotodetail').prop('src', '/postingan/'+res.dataDetailFoto.lokasi_file)
        $('#fotoprofil').prop('src', '/pic/'+res.dataDetailFoto.users.foto_profil)
        $('#judulfoto').html(res.dataDetailFoto.judul_foto)
        $('#username').html(res.dataDetailFoto.users.username)
        $('#deskripsifoto').html(res.dataDetailFoto.deksripsi_foto)
        if(res.dataDetailFoto.album_id != null)  $('#album').html(res.dataDetailFoto.album.Nama_Album)
        $('#jumlahpengikut').html(res.dataJumlahFollow.jmlfolow + ' Pengikut')
        ambilKomentar()
        var idUser ;
        if(res.dataFollow == null){
            idUser=""
        } else {
            idUser = res.dataFollow.users_id
        }
        if(res.dataDetailFoto.users_id === res.dataUser){
            $('#tombolfollow').html('')
        } else {
            if(idUser == res.dataUser){
                $('#tombolfollow').html(' <button class="px-4 rounded-full bg-blue-600 text-white" onclick = "ikuti(this, '+res.dataDetailFoto.users_id+')">unfollow</button>')
            } else {
                $('#tombolfollow').html(' <button class="px-4 rounded-full bg-blue-600 text-white" onclick = "ikuti(this, '+res.dataDetailFoto.users_id+')">follow</button>')
            }
        }


    },
    error: function(jqXHR, textStatus, errorThrown){
        alert('gagal')
    }
})


//datakomentar
function ambilKomentar(){
    $.getJSON(window.location.origin +'/explore-detail/getkomen/'+segmentTerakhir, function(res){
        // console.log(res)
        if(res.data.lenght === 0){
            $('#komentar').html('<div>Belum ada komentar</div>')
        } else {
            komen= []
            res.data.map((x)=>{
                let datakomentar = {
                    idUser: x.users.id,
                    pengirim: x.users.username,
                    waktu: x.created_at,
                    isikomentar: x.isi_komentar,
                    potopengirim: x.users.foto_profil,
                }
                komen.push(datakomentar);
            })
            tampilkankomentar()
        }
    })
}

//menampilkan komentar
const tampilkankomentar = ()=>{
    $('#komentar').html('')
    komen.map((x, i)=>{
        $('#komentar').append(`
                <article class=" mb-3 text-base">
                    <footer class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <p
                                class="inline-flex items-center mr-3 text-md text-gray-900 dark:text-white font-semibold">
                                <img class="mr-2 w-8 h-8 rounded-full"
                                    src="/pic/${x.potopengirim}"
                                    alt="">${x.pengirim}
                            </p>
                        </div>
                        <button id="dropdownComment3Button" data-dropdown-toggle="dropdownComment3"
                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 dark:text-gray-40 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            type="button">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 16 3">
                                <path
                                    d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                            </svg>
                            <span class="sr-only">Comment settings</span>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownComment3"
                            class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownMenuIconHorizontalButton">
                                <li>
                                    <a href="#"
                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                </li>
                            </ul>
                        </div>
                    </footer>
                    <p class="text-gray-500 dark:text-gray-400">${x.isikomentar}</p>
                </article>
        `)

    })

}

//buatkomentar
function kirimkomentar(){
    $.ajax({
        url: window.location.origin +'/explore-detail/kirimkomentar',
        dataType: "JSON",
        type: "POST",
        data: {
            _token: $('input[name="_token"]').val(),
            idfoto: segmentTerakhir,
            isi_komentar: $('input[name="textkomentar"]').val()
        },
        success: function(res){
            $('input[name="textkomentar"]').val('')
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('gagal mengirim komentar')
        }
    })
}

// setInterval(ambilKomentar, 500);

//follow
function ikuti(txt, idfollow){
    $.ajax({
        url: window.location.origin +'/explore-detail/ikuti',
        dataType: "JSON",
        type: "POST",
        data: {
            _token: $('input[name="_token"]').val(),
            idfollow: idfollow
        },
        success:function(res){
            location.reload()
        },
        error:function(jqXHR, textStatus, errorThrown){
            alert('gagal')

        }
    })
}
//postinganbawah
var paginate = 1;
var dataExplore = [];
loadMoreData(paginate);
$(window).scroll(function(){
    if($(window).scrollTop() + $(window).height() >= $(document).height()){
        paginate++;
        loadMoreData(paginate);
    }
})
function loadMoreData(paginate){
    $.ajax({
        url: window.location.origin +'/getDataExplore'+ '?page='+paginate,
        type: "GET",
        dataType: "JSON",
        success: function(e){
            console.log(e)
            e.data.data.map((x)=>{
                //Format Tanggal
                var tanggal = x.created_at;
                var tanggalObj = new Date(tanggal);
                var tanggalFormatted = ('0' + tanggalObj.getDate()).slice(-2);
                var bulanFormatted = ('0' + (tanggalObj.getMonth() + 1)).slice(-2);
                var tahunFormatted = tanggalObj.getFullYear();
                var tanggalupload = tanggalFormatted + '-' + bulanFormatted + '-' + tahunFormatted;
                var hasilPencarian = x.likefoto.filter(function(hasil){
                    return hasil.users_id === e.idUser
                })
                if(hasilPencarian.length <= 0){
                    userlike = 0;
                } else {
                    userlike = hasilPencarian[0].users_id;
                }
                let datanya = {
                    id: x.id,
                    judul_foto: x.judul_foto,
                    deksripsi_foto: x.deksripsi_foto,
                    foto: x.lokasi_file,
                    created_at: tanggalupload,
                    Nama_Album : x.album ? x.album.Nama_Album :('-'),
                    username: x.users.username,
                    foto_profil: x.users.foto_profil,
                    jml_komen: x.komenfoto_count,
                    jml_like: x.likefoto_count,
                    idUserLike: userlike,
                    useractive: e.idUser,
                    users_id: x.users_id,
                }
                dataExplore.push(datanya)
                console.log(userlike)
                console.log(e.idUser)
            })
            getExplore()
        },
        error: function(jqXHR, textStatus, errorThrown){

        }

    })
}
//pengulangan data
const getExplore =()=>{
    $('#exploredatapostingan').html('')
    dataExplore.map((x, i)=>{
        $('#exploredatapostingan').append(
            `
            <div class="flex flex-wrap items-center flex-container">
                    <div class="flex mt-2">
                        <div class="mt-2 flex flex-col px-2 py-4 bg-white shadow-md rounded-md">
                            <div class="mb-2" style="position-relative">
                                <div class="ml-2 flex justify-between space-x-2">
                                    <a href="/profil_public/${x.users_id}">
                                        <div class="flex flex-wrap items-center space-x-2">
                                            <img src="/pic/${x.foto_profil}" alt="User Avatar" class="w-8 h-8 rounded-full">
                                            <div>
                                                <p class="text-gray-800 font-semibold">${x.username}</p>
                                                <p class="text-gray-500 text-sm">${x.created_at}</p>
                                            </div>
                                        </div>
                                    </a>
                                    <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots"
                                            class="hover:bg-gray-50 rounded-full p-1 font-medium"
                                            type="button" onclick="toggleContent(${i})">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <circle cx="12" cy="7" r="1" />
                                                <circle cx="12" cy="17" r="1" />
                                                <circle cx="12" cy="12" r="1" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="dropdownDots${i}" class="z-10 hidden  bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600" style="position:absolute; right:0">
                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                                                <li>
                                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                        Laporkan
                                                    </a>
                                                </li>
                                            </ul>
                                    </div>
                            </div>
                            <a href="/explore-detail/${x.id}">
                                <div class="w-[363px] h-[192px] overflow-hidden rounded-md">
                                    <img src="/postingan/${x.foto}" alt=""
                                        class="w-full transition duration-500 ease-in-out hover:scale-105">
                                </div>
                            </a>
                            <div class="flex flex-wrap items-center justify-between px-2 mt-2">
                                <div>
                                    <div class="flex flex-col">
                                        <div class="font-bold">
                                            ${x.judul_foto}
                                        </div>
                                        <div>
                                            ${x.deksripsi_foto}
                                        </div>
                                        <div class="text-blue-500 text-sm">
                                            ${x.Nama_Album}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <span class="bi bi-chat-left-text"></span>
                                    <small>${x.jml_komen}</small>
                                    <span class="bi ${x.idUserLike === x.useractive ? 'bi-heart-fill' : 'bi-heart' }" onclick="likes(this, ${x.id})"></span>
                                    <small>${x.jml_like}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--postingan-->
                </div>
                    
            `
        )
    });
}
//toggle
function toggleContent(index) {
    var dropdown = document.getElementById('dropdownDots' + index);
    if (dropdown.style.display === 'none' || dropdown.style.display === '') {
        dropdown.style.display = 'block';
    } else {
        dropdown.style.display = 'none';
    }
}
//likefoto
function likes(txt, id){
    $.ajax({
        url: window.location.origin +'/likefoto',
        dataType: "JSON",
        type: "POST",
        data: {
            _token: $('input[name="_token"]').val(),
            idfoto: id
        },
        success:function(res){
            console.log(res)
        },
        error:function(jqXHR, textStatus, errorThrown){
            alert('gagal')

        }
    })
}