<x-app-layout>
    <x-breadcrumbs breadcrumbs_location="Un poco de historia" />

    <div class="max-w-6xl mx-auto py-20 px-4 un-poco-de-historia container">

        <h2 class="text-3xl font-bold mb-16 text-center flex items-center justify-center gap-3">
            📖 Un poco de historia
        </h2>

        <div class="relative">

            <!-- Línea base -->
            <div class="absolute md:left-1/2 top-0 md:-translate-x-1/2 w-1 bg-gray-300 h-full"></div>

            <!-- Línea que se pinta -->
            <div id="timeline-progress"
                 class="absolute md:left-1/2 top-0 md:-translate-x-1/2 w-1 bg-primary h-0 transition-all duration-700">
            </div>

            <div class="flex flex-col gap-28">

                <!-- 2000s -->
                <div class="timeline-item opacity-0 translate-y-10 transition-all duration-700 relative flex flex-col md:flex-row items-start">

                    <!-- TEXTO -->
                    <div class="md:w-1/2 md:pr-12 md:text-right ml-6 md:ml-0">
                        <h4 class="text-primary font-semibold mb-2">Años 2000</h4>
                        <div class="bg-gray-50 p-6 rounded-xl shadow-sm border">
                            <p>
                                <strong>El Vocerito</strong> nació a comienzos de los años 2000 con un objetivo claro: 
                                <em>conectar a las personas con los servicios, oficios y comercios de su comunidad.</em> 
                                En sus inicios, fue una revista gráfica que rápidamente se convirtió en un referente local en 
                                <strong>Quilmes y alrededores</strong>, acompañando el crecimiento de emprendedores, trabajadores independientes y empresas que buscaban darse a conocer.
                            </p>
                        </div>
                    </div>

                    <!-- DOT CENTRADO -->
                    <div class="absolute -left-2 top-0 md:left-1/2 md:-translate-x-1/2">
                        <div class="timeline-dot"></div>
                    </div>

                    <!-- IMAGEN -->
                    <div class="md:w-1/2 md:pl-12 mt-6 md:mt-0 ml-6 md:ml-0">
                        <img src="{{ asset('storage/common/revista.png') }}" class="rounded-xl shadow-md w-full object-cover" alt="">
                    </div>
                </div>

                <!-- DIGITAL -->
                <div class="timeline-item opacity-0 translate-y-10 transition-all duration-700 relative flex flex-col-reverse md:flex-row items-start">

                    <!-- IMAGEN -->
                    <div class="md:w-1/2 md:pr-12 order-2 md:order-1 mt-6 md:mt-0 ml-6 md:ml-0">
                        <img src="{{ asset('storage/common/era_digital_min.png') }}" class="rounded-xl shadow-md w-full object-cover" alt="">
                    </div>

                    <!-- DOT CENTRADO -->
                    <div class="absolute -left-2 top-0 md:left-1/2 md:-translate-x-1/2">
                        <div class="timeline-dot"></div>
                    </div>

                    <!-- TEXTO -->
                    <div class="md:w-1/2 md:pl-12 text-left order-3 ml-6 md:ml-0">
                        <h4 class="text-primary font-semibold mb-2">Etapa digital</h4>
                        <div class="bg-gray-50 p-6 rounded-xl shadow-sm border">
                            <p>
                                Con el paso del tiempo, <strong>El Vocerito</strong> supo adaptarse a los cambios y a las nuevas formas de comunicación. 
                                Así, la guía evolucionó hacia el entorno digital 🌐, dando origen a <strong>ElVocerito.com</strong>, 
                                un espacio online que mantiene el mismo espíritu de <em>cercanía y confianza</em>, ahora potenciado por la tecnología y el alcance de Internet.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CONSOLIDACIÓN -->
                <div class="timeline-item opacity-0 translate-y-10 transition-all duration-700 relative flex flex-col md:flex-row items-start">

                    <!-- TEXTO -->
                    <div class="md:w-1/2 md:pr-12 md:text-right ml-6 md:ml-0">
                        <h4 class="text-primary font-semibold mb-2">Más de 20 años</h4>
                        <div class="bg-gray-50 p-6 rounded-xl shadow-sm border">
                            <p>
                                Durante más de dos décadas, <strong>miles de avisos y publicaciones</strong> 🧾 formaron parte de nuestra historia, consolidando a 
                                <strong>El Vocerito</strong> como una guía confiable, profesional y reconocida, tanto por anunciantes como por usuarios. 
                                La experiencia acumulada y la permanencia en el tiempo le permitieron alcanzar un sólido posicionamiento y una identidad propia dentro del ámbito local.
                            </p>
                        </div>
                    </div>

                    <!-- DOT CENTRADO -->
                    <div class="absolute -left-2 top-0 md:left-1/2 md:-translate-x-1/2">
                        <div class="timeline-dot"></div>
                    </div>

                    <!-- IMAGEN -->
                    <div class="md:w-1/2 md:pl-12 mt-6 md:mt-0 ml-6 md:ml-0">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/oAVErbQjTpw?si=lBsv4hxjLGYRxn2h&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen class="rounded-xl shadow-md max-w-full object-cover">
                        </iframe>
                    </div>
                </div>

                <!-- PRESENTE -->
                <div class="timeline-item opacity-0 translate-y-10 transition-all duration-700 relative flex flex-col-reverse md:flex-row items-start">

                    <!-- IMAGEN -->
                    <div class="md:w-1/2 md:pr-12 order-2 md:order-1 mt-6 md:mt-0 ml-6 md:ml-0">
                        <img src="{{ asset('storage/common/costa_quilmes.jpeg') }}" class="rounded-xl shadow-md w-full object-cover" alt="">
                    </div>

                    <!-- DOT CENTRADO -->
                    <div class="absolute -left-2 top-0 md:left-1/2 md:-translate-x-1/2">
                        <div class="timeline-dot"></div>
                    </div>

                    <!-- TEXTO -->
                    <div class="md:w-1/2 md:pl-12 order-3 ml-6 md:ml-0">
                        <h4 class="text-primary font-semibold mb-2">Hoy</h4>
                        <div class="bg-gray-50 p-6 rounded-xl shadow-sm border">
                            <p class="font-medium">
                                Hoy, <strong>GUÍA VOCERITO</strong> continúa creciendo 🚀, combinando su trayectoria con herramientas digitales modernas, 
                                sin perder de vista su esencia: <em>ser un puente entre quienes ofrecen un servicio y quienes lo necesitan</em> 🤝, 
                                fortaleciendo el desarrollo comercial y profesional de la comunidad.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const items = document.querySelectorAll(".timeline-item");
    const progressLine = document.getElementById("timeline-progress");

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.remove("opacity-0", "translate-y-10");
                entry.target.classList.add("opacity-100", "translate-y-0");
            }
        });
    }, { threshold: 0.3 });

    items.forEach(item => observer.observe(item));

    window.addEventListener("scroll", () => {
        const timeline = document.querySelector(".relative");
        const rect = timeline.getBoundingClientRect();
        const progress = Math.min(Math.max((window.innerHeight - rect.top) / rect.height, 0), 1);
        progressLine.style.height = (progress * 100) + "%";
    });

});
</script>