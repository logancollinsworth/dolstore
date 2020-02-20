@extends('layout')

@section('style')
    <style>
        .carousel-open:checked + .carousel-item {
            position: static;
            opacity: 100;
        }

        .carousel-item {
            -webkit-transition: opacity 0.6s ease-out;
            transition: opacity 0.6s ease-out;
        }

        #carousel-1:checked ~ .control-1,
        #carousel-2:checked ~ .control-2,
        #carousel-3:checked ~ .control-3 {
            display: block;
        }

        .carousel-indicators {
            list-style: none;
            margin: 0;
            padding: 0;
            position: absolute;
            bottom: 2%;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 10;
        }

        #carousel-1:checked ~ .control-1 ~ .carousel-indicators li:nth-child(1) .carousel-bullet,
        #carousel-2:checked ~ .control-2 ~ .carousel-indicators li:nth-child(2) .carousel-bullet,
        #carousel-3:checked ~ .control-3 ~ .carousel-indicators li:nth-child(3) .carousel-bullet {
            color: #2b6cb0;
            /*Set to match the Tailwind colour you want the active one to be */
        }
    </style>
@endsection

@section('content')
    <div class="bg-gray-100">
        <div class="container mx-auto w-full pt-4">
            <div class="flex justify-between mb-2">
                {{-- breadcrumb --}}
                <span>HOME / MENS / SHIRTS</span>
                <div>
                    @foreach($product->categories()->pluck('name') as $category)
                        <span class="mx-1 p-1 bg-gray-300 rounded">{{ $category }}</span>
                    @endforeach
                </div>
            </div>
            <div class="flex pb-10">
                <div class="w-1/2">
                    {{-- image carousel / lightbox --}}
                    <div class="carousel relative min-h-full px-4">
                        <div class="carousel-inner relative overflow-hidden w-full">
                        @foreach ($product->images as $image)
                            <!--Slide 1-->
                                <input class="carousel-open" type="radio" id="carousel-{{ $image->id }}" name="carousel"
                                       aria-hidden="true" hidden="" checked="checked">
                                <div class="carousel-item absolute opacity-0" style="height:50vh;">
                                    <div class="block h-full w-full bg-indigo-500 text-white text-5xl text-center"
                                         style="background-image: url('{{  asset('storage/' . explode("/", $image->path)[1]) }}');background-size:cover; background-position: center">
                                    </div>
                                </div>
                                <label for="carousel-3"
                                       class="prev control-1 w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-blue-700 leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
                                <label for="carousel-2"
                                       class="next control-1 w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-blue-700 leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>

                        @endforeach

                        <!-- Add additional indicators for each slide-->
                            <ol class="carousel-indicators">
                                @foreach ($product->images as $image)
                                    <li class="inline-block mr-3">
                                        <label for="carousel-{{ $image->id }}"
                                               class="carousel-bullet cursor-pointer block text-4xl text-white hover:text-blue-700">•</label>
                                    </li>
                                @endforeach
                            </ol>

                        </div>
                    </div>
                </div>
                <div class="w-1/2 bg-gray-200 p-4" style="height:700px">
                    {{-- info and cart controls --}}
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <h1 class="text-4xl" style="font-family: Nunito;font-weight:200;">{{ $product->name }}</h1>
                        <div class="flex justify-between text-gray-800">
                            <div>&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                            <div><a class="hover:underline" href=" #">No Reviews</a></div>
                        </div>
                        <div class="text-gray-900">{{ $product->description }}</div>
                        <div class="mt-10 mx-auto w-5/6 p-2">
                            {{-- Sizes --}}
                            <span class="text-gray-800 font-thin text-lg">Size</span>
                            <div class="flex flex-wrap justify-around p-2">

                            @foreach(\App\Helper::sizes() as $size)
                                <!-- begin size -->
                                    <div class="pretty p-icon p-round -mx-2 p-smooth">
                                        <input type="radio" name="size"/>
                                        <div class="state p-danger">
                                            <i class="icon mdi mdi-check"></i>
                                            <label>{{ strtoupper($size) }}</label>
                                        </div>
                                    </div>
                                    <!-- end size -->
                                @endforeach


                            </div>
                            <div class="flex flex-col justify-between w-5/6 mx-auto mt-6">
                                <label for="quantity">Quantity</label>
                                <div class="flex">
                                    <select class="py-2 px-4 w-40" name="quantity">
                                        @for ($i = 0; $i <= 20; $i++)
                                            <option value="<?= $i; ?>"><?= $i; ?></option>
                                        @endfor
                                    </select>
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 w-full ml-4"
                                            type="submit">Add to
                                        Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
