var paginate = 1;
var dataExplore1 = [];
loadMoreData1(paginate);
$(window).scroll(function(){
    if($(window).scrollTop() + $(window).height() >= $(document).height()){
        paginate++;
        loadMoreData1(paginate);
    }
})
function loadMoreData1(paginate){
    $.ajax({
        url: window.location.origin +'/getDataAlbum'+ '?page='+paginate,
        type: "GET",
        dataType: "JSON",
        success: function(e){
            console.log(e)
            e.data.data.map((x)=>{
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
                    Nama_Album : x.album.Nama_Album,
                    username: x.users.username,
                    foto_profil: x.users.foto_profil,
                    jml_komen: x.komenfoto_count,
                    jml_like: x.likefoto_count,
                    idUserLike: userlike,
                    useractive: e.idUser,
                    users_id: x.users_id,
                }
                dataExplore1.push(datanya)
                console.log(userlike)
                console.log(e.idUser)
            })
            getExplore1()
        },
        error: function(jqXHR, textStatus, errorThrown){

        }

    })
}
//pengulangan data
const getExplore1 =()=>{
    $('#albumfoto').html('')
    dataExplore1.map((x, i)=>{
        $('#albumfoto').append(
            `
                    <div class="flex mt-2">
                        <div class="mt-2 flex flex-col px-2 py-4 bg-white shadow-md rounded-md">
                            <div class="mb-2" style="position:relative">
                                <div class="ml-2 flex justify-between space-x-2">
                                    <a href="/album">
                                        <div class="flex flex-wrap items-center space-x-2">
                                            <img src="/pic/${x.foto_profil}" alt="User Avatar"
                                                class="w-8 h-8 rounded-full">
                                            <div>
                                                <p class="text-gray-800 font-semibold">${x.username}</p>
                                                <p class="text-gray-500 text-sm">${x.created_at}</p>
                                            </div>
                                        </div>
                                    </a>
                                <!-- Dropdown menu -->
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
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                <button type="button" data-id="${x.id}" class="block btn-delete-foto px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                    Hapus
                                                </button>
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
                                    <span class="bi ${x.idUserLike === x.useractive ? 'bi-heart-fill bg-red-800' : 'bi-heart' }" onclick="likes(this, ${x.id})"></span>
                                    <small>${x.jml_like}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
            `
        )
    })
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
//delete foto
$(document).ready(function(){
    // likefoto
    $('.btn-delete-foto').on('click', function(){
        var id = $(this).data('id');
        alert('oke');   
        deletefoto(id);
    });

    function deletefoto(id){
        $.ajax({
            url: '/deletefoto/' + id,
            dataType: "JSON",
            type: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'), // Use the correct method to get CSRF token
                id: id
            },
            success: function(res){
                $('#elemen-foto-' + id).empty(); // Use 'empty' instead of 'html' to clear the content
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('gagal');
            }
        });
    }
});

