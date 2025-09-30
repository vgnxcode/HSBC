import { Component, OnInit, ElementRef, Renderer2,Inject } from '@angular/core';
import { DOCUMENT } from '@angular/common';
import { NavigationEnd, Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'VGN';

  constructor(private router: Router, private elementRef: ElementRef, private _renderer2: Renderer2,@Inject(DOCUMENT) private _document: Document ) {
  }


  ngOnInit() {

    this.router.events.subscribe((event) => {
      if (event instanceof NavigationEnd) {
        if(this.router.url=='/home'){
          if(event.id!=1){
          window.location.reload();
          }
        //console.log(event);
        // var s1 = document.createElement("script");
        // s1.type = "text/javascript";
        // s1.src = "https://static.addtoany.com/menu/page.js";
        // const child = this.elementRef.nativeElement.appendChild(s1);
        // console.log(s1);
     
        let script1 = this._renderer2.createElement('script');
        script1.type = `text/javascript`;
        script1.src = `https://static.addtoany.com/menu/page.js`;

        this._renderer2.appendChild(this._document.head, script1);
        // this.renderer.appendChild(this.elementRef.nativeElement, child);
        }
      }

    })

  }
}

// let cc = window as any;
// cc.cookieconsent.initialise({

//  palette: {
//    popup: {
//      background: "#ffffff"
//    },
//    button: {
//      background: "#e02227",
//      text: "#ffffff"
//    }
//  },
//  position: "top-left",
//  theme: "classic",
//  type: "opt-out",
//  content: {
//     "message": "This website uses cookies to ensure you get the best experience on our website.",
//     "dismiss": "Got it!",
//     "deny": "Decline cookies",
//     "link": "Privacy Policy",
//     "href": "{{ url()->full() }}/vgn/privacypolicy", 
//     "policy": "Cookie Policy",
//     "allow": "Allow cookies",
//   },
//  location: true,
// });