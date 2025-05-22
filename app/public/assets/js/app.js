const app = {
    routes : {
        home          : '/home',
        inisession    : "/Session/iniSession",
        login         : "/Session/userAuth",
        register      : "/Register/register",
        prevpost      : '/Posts/getPosts',
        lastpost      : '/Posts/lastPost',
        openpost      : '/Posts/openPost',
        togglelike    : '/Posts/toggleLike',
        togglecomments: '/Posts/getComments',
        savecomment   : '/Posts/saveComment',
        citas : '/Citas/getCitas',

    },
    user :{
            sv      : false,
            id      : '',
            username: '',
            tipo    : ''
    },
    $pp : $("#prev-posts"),
    $lp : $("#content"),

    mainPostHTMLBuilder : function(citas){
        console.log(citas)
        return `
                <div class="container">
                    <div class="card doctor-card">
                        <h1>7 de 14</h1>
                        <p>DOCTORES DISPONIBLES</p>
                    </div>
                
                    <div class="card patient-card">
                        <h1>15</h1>
                        <p>PACIENTES</p>
                    </div>
                
                    <div class="card appointment-card">
                        <h1>${citas[0].tt}</h1>
                        <p>TOTAL DE CITAS DEL DÍA</p>
                    </div>
                </div>
        `
    },

    citas : function(){
        
    },

    getCitas : async function(){
        try{
            let html = "<h2>Aún no hay citas</h2>"
            this.$lp.html("")
            console.log("User ID:", app.user.id)
            const $citas = await $.getJSON( this.routes.citas + '/' + app.user.id)
            if( $citas.length > 0){
                html = this.mainPostHTMLBuilder($citas)
            }
            this.$lp.html( html )
        }catch( err ){ console.error( err )}
    },


    lastPost : async function(){
        try{
            let html = "<h2>Aún no hay publicaciones</h2>"
            this.$lp.html("")
            const $lpost = await $.getJSON( this.routes.lastpost)
            if( $lpost.length > 0 ){
                html = this.mainPostHTMLBuilder($lpost)
            }
            this.$lp.html( html )

        }catch( err ){ console.error( err )}
    },

    openPost : async function( event,pid,element ){
        event.preventDefault();
        $(".pplg").removeClass("active")
        element.classList.add("active")
        try{
            let html = ""
            this.$lp.html("")
            const $opost = await $.getJSON( this.routes.openpost + '/' + pid)
            html = this.mainPostHTMLBuilder($opost)
            this.$lp.html( html )

        }catch( err ){ console.error( err )}
    },


    toggleLike : function(e,pid,uid){
        e.preventDefault();
        try{
            fetch( this.routes.togglelike + '/' + pid + '/' +uid,{

            })
                .then( resp => resp.json() )
                .then( resp => {
                    $("#likes").html(`${ resp[0].tt } ${ resp[0].liked ? ' - Te gusta' : '' }`)
                    $("#iLikeHand").toggleClass("bi-hand-thumbs-up-fill",resp[0].liked)
                    $("#iLikeHand").toggleClass("bi-hand-thumbs-up",!resp[0].liked)
                }).catch( err => console.error( err ))

        }catch( err ){ console.error( err )}
    },
    toggleComments : async function (event,pid,element){
        if(event){
            event.preventDefault()
            $(element).toggleClass('d-none')
        }else{
            $(element).removeClass('d-none')
        }
        try {
            const $comments = await $.getJSON( this.routes.togglecomments + '/' + pid)
            if( $comments.length > 0 ){
                let html = ''
                for( let c of $comments){
                    html += `
                        <li class="list-group-item">
                            <p class="mb-0">
                                <span class="fw-bold">${ c.name }</span> | ${ c.fecha }
                            </p>
                            <p class="mb-0">${ c.body }</p>
                        </li>`
                }
                $(element).html ( html )
            }
        }catch( err ){ console.error( err )}
    },
    saveComment : function(e,pid,uid){
        e.preventDefault()
        data = new FormData()
        data.append("comment" , $("#comment").val() )
        try{
            fetch( this.routes.savecomment + '/' + pid + '/' + uid,{
                method : 'POST',
                body : data
            } )
                .then( resp => resp.json() )
                .then( resp => {
                    $("#tt-comments").text(resp[0].tt)
                    app.toggleComments(null,pid,'#post-comments')
                    $("#comment").val("")
                }).catch(err => console.error( err ))
        }catch( err ){ console.error( err ) } 

    }

}