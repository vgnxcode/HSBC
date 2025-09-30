import { NgModule, CUSTOM_ELEMENTS_SCHEMA, NO_ERRORS_SCHEMA} from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';

import { AppComponent } from './app.component';

import { HomeComponent } from './home/home.component';
import { HeaderComponent } from './header/header.component';
import { FooterComponent } from './footer/footer.component';

import { OngoingProjectComponent } from './ongoing-project/ongoing-project.component';
import { ReadytomoveProjectComponent } from './readytomove-project/readytomove-project.component';
import { CompletedProjectComponent } from './completed-project/completed-project.component';
import { InvestorsComponent } from './investors/investors.component';
import { SearchComponent } from './search/search.component';

import { AppRoutingModule } from './app-routing.module';

import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

import {MatSnackBarModule} from '@angular/material/snack-bar';


import {  NgxSlickJsModule } from 'ngx-slickjs';
import { ReplaceUnderscorePipe } from './replace-underscore.pipe';

import {MatSelectModule} from '@angular/material/select';
import { SitemapComponent } from './sitemap/sitemap.component';
import { TermsAndConditionsComponent } from './terms-and-conditions/terms-and-conditions.component';
import { BlogComponent } from './blog/blog.component';
import { ShortingPipe } from './shorting.pipe';






@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    HeaderComponent,
    FooterComponent,
    OngoingProjectComponent,
    ReadytomoveProjectComponent,
    CompletedProjectComponent,
    ReplaceUnderscorePipe,
    InvestorsComponent,
    SearchComponent,
    SitemapComponent,
    TermsAndConditionsComponent,
    BlogComponent,
    ShortingPipe
  ],
  imports: [
    AppRoutingModule,
    BrowserModule,
    HttpClientModule,
    FormsModule,
    BrowserAnimationsModule,
    MatSnackBarModule,
    MatSelectModule,
    NgxSlickJsModule.forRoot({
      links: {
        jquery: "https://code.jquery.com/jquery-3.4.0.min.js",
        slickJs: "https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js",
        slickCss: "https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css",
        slickThemeCss: "https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"
      }
  })
  ],
  providers: [],
  bootstrap: [AppComponent],
  schemas: [
    CUSTOM_ELEMENTS_SCHEMA,
    NO_ERRORS_SCHEMA
  ]
})
export class AppModule {}
