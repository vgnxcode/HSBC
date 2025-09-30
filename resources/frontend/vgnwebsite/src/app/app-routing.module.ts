import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';


import { HomeComponent } from './home/home.component';
// import { HeaderComponent } from './header/header.component';
// import { FooterComponent } from './footer/footer.component';
import { AboutusComponent } from './aboutus/aboutus.component';
import { ContactusComponent } from './contactus/contactus.component';
import { DisclaimerComponent } from './disclaimer/disclaimer.component';
import { PrivacypolicyComponent } from './privacypolicy/privacypolicy.component';

import { OngoingProjectComponent } from './ongoing-project/ongoing-project.component';
import { ReadytomoveProjectComponent } from './readytomove-project/readytomove-project.component';
import { CompletedProjectComponent } from './completed-project/completed-project.component';
import { InvestorsComponent } from './investors/investors.component';
import { SearchComponent } from './search/search.component';

import { SitemapComponent } from './sitemap/sitemap.component';
import { TermsAndConditionsComponent } from './terms-and-conditions/terms-and-conditions.component';

import { PagenotfoundComponent } from './pagenotfound/pagenotfound.component';

import { BlogComponent } from './blog/blog.component';

const routes: Routes = [
  { path: 'home', component: HomeComponent },
  // { path: 'header', component: HeaderComponent },
  // { path: 'footer', component: FooterComponent },
  { path: 'aboutus', component: AboutusComponent },
  { path: 'contactus', component: ContactusComponent },
  { path: 'disclaimer', component: DisclaimerComponent },
  { path: 'privacypolicy', component: PrivacypolicyComponent },
  {path: 'ongoingproject', component: OngoingProjectComponent },
  {path: 'readytomoveproject', component: ReadytomoveProjectComponent },
  {path: 'investors', component: InvestorsComponent },
  {path: 'completedproject', component: CompletedProjectComponent },
  {path: 'search', component: SearchComponent },
  {path: 'sitemap', component: SitemapComponent },
  {path: 'termsandconditions', component: TermsAndConditionsComponent },
  {path: 'blog', component: BlogComponent },
  // { path: '',   redirectTo: 'home', pathMatch: 'full' },
  { path: '**', redirectTo: 'home'}
];

@NgModule({
  declarations:[
    // HomeComponent,
    // HeaderComponent,
    // FooterComponent,
    AboutusComponent,
    ContactusComponent,
    DisclaimerComponent,
    PrivacypolicyComponent,
    
  ],
  imports: [
    RouterModule.forRoot(routes)
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
