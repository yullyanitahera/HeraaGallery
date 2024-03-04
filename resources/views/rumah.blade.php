<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto</title>
    <link rel="short icon" href="/assets/logoo.png">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hurricane&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="bg-white border-gray-300 shadow-md px-4 lg:px-6 py-2.5 dark:bg-gray-800">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                <a href="/" class="flex items-center">
                    <img src="/assets/logoo.png"
                        class="mr-3 h-6 sm:h-9 w-full transition duration-300 ease-in-out hover:scale-105"
                        alt="Flustpicture Logo" />
                    <span
                        class="self-center text-xl font-pacifico whitespace-nowrap dark:text-white">Gallery Photo</span>
                </a>
                <div class="flex gap-1">
                    <a href="/login"
                        class="inline-flex justify-center items-center py-3 px-4 text-base  font-semibold text-center text-gray-900 rounded-lg  hover:bg-blue-200 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-blue-700 dark:focus:ring-white">
                        LOG IN
                    </a>
                    <a href="/register"
                        class="inline-flex justify-center items-center py-3 px-4 text-base font-semibold text-center text-gray-900 rounded-lg  hover:bg-blue-200 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-blue-700 dark:focus:ring-white">
                        REGISTER
                    </a>
                </div>
    </header>
    <section class="mt-32 mb-5">
      <div class="flex max-w-screen-md mx-auto flex-wrap">
           <div class="lg:w-1/2 mx-auto">
                <div class="flex flex-col">
                     <div class="w-[363px] h-[192px] bg-slate-500 overflow-hidden">
                          <img src="/assets/doy7.jpg " alt="">
                     </div>
                     <div>
                          <div class="flex items-center justify-between mr-6">
                               <div>
                                    <div class="flex flex-col">
                                         <div>
                                              <span class="">live doyoung</span>
                                         </div>
                                         <div>
                                              <span class="text-xs text-gray-500">1h</span>
                                         </div>
                                    </div>
                               </div>
                          </div>
                     </div>
                </div>
           </div>
           <div class="lg:w-1/2 mx-auto">
              <div class="flex flex-col">
                   <div class="w-[363px] h-[192px] bg-slate-500 overflow-hidden">
                        <img src="/assets/doy9.jpg" alt="">
                   </div>
                   <div>
                        <div class="flex items-center justify-between mr-6">
                             <div>
                                  <div class="flex flex-col">
                                       <div>
                                            <span class="">pantai doy</span>
                                       </div>
                                       <div>
                                            <span class="text-xs text-gray-500">1h</span>
                                       </div>
                                  </div>
                             </div>
                        </div>
                   </div>
              </div>
         </div>
           <div class="lg:w-1/2 mx-auto">
              <div class="flex flex-col">
                   <div class="w-[363px] h-[192px] bg-slate-500 overflow-hidden mt-2">
                        <img src="/assets/doy6.jpg" alt="">
                   </div>
                   <div>
                        <div class="flex items-center justify-between mr-6">
                             <div>
                                  <div class="flex flex-col">
                                       <div>
                                            <span class=""> live doy</span>
                                       </div>
                                       <div>
                                            <span class="text-xs text-gray-500">1h</span>
                                       </div>
                                  </div>
                             </div>
                        </div>
                   </div>
              </div>
         </div>
         <div class="lg:w-1/2 mx-auto">
          <div class="flex flex-col">
               <div class="w-[363px] h-[192px] bg-slate-500 overflow-hidden mt-2">
                    <img src="/assets/doy5.jpg" alt="" >
               </div>
               <div>
                    <div class="flex items-center justify-between mr-6">
                         <div>
                              <div class="flex flex-col">
                                   <div>
                                        <span class="">Photo shoot</span>
                                   </div>
                                   <div>
                                        <span class="text-xs text-gray-500">1h</span>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
  
      </div>
  </section>
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
            <h2
                class="mb-8 text-3xl font-hurricane tracking-tight leading-tight text-center text-gray-900 lg:mb-16 dark:text-white md:text-4xl">
                Gallery photo</h2>
        </div>
    </section>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>
