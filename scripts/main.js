$(window).ready( () => {
    // variaveis
    let ajudaBoard = true
    let ajudaBoardDebounce = true

    // preparacoes
    $('#ajudaBoard').css("height", 0)

    // eventos, etc...

    function AjudaDebounce(){
        ajudaBoardDebounce = true
    }

    $('#ajudabutton').on("click", () => {
        if(ajudaBoard && ajudaBoardDebounce){
            $('#ajudaBoard').animate({
                "height": "100px"
            }, 1500)

            ajudaBoard = false
            ajudaBoardDebounce = false

            setTimeout(AjudaDebounce, 1600)
        }else if(!ajudaBoard && ajudaBoardDebounce) {
            $('#ajudaBoard').animate({
                "height": "0px"
            }, 1500)

            ajudaBoard = true
            ajudaBoardDebounce = false

            setTimeout(AjudaDebounce, 1600)
        }
    })

    // requisições ajax

    $("#dashboardbutton").on("click", () =>{
        $("#header").load("paginas/dashboard.html")
    })

    $("#documentacaobutton").on("click", () => {
        $("#header").load("paginas/documentacao.html")
    });

    $("#suportebutton").on("click", () =>{
        $("#header").load("paginas/suporte.html")
    })
})