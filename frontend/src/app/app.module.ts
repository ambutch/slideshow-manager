import {NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';
import {HttpClientModule} from "@angular/common/http";
import {RouterModule} from "@angular/router";

import {NoopAnimationsModule} from "@angular/platform-browser/animations";
import {MatToolbarModule} from '@angular/material/toolbar';
import {MatSidenavModule} from '@angular/material/sidenav';
import {MatGridListModule} from '@angular/material/grid-list';
import {MatButtonModule} from '@angular/material/button';
import {MatTreeModule} from '@angular/material/tree';
import {MatIconModule} from '@angular/material/icon';
import {MatCheckboxModule} from '@angular/material/checkbox';
import {MatDialogModule} from '@angular/material/dialog';

import {ApiModule, Configuration} from "../api";
import {AppComponent} from './app.component';
import {TreeComponent} from './tree/tree.component';
import {ListComponent} from './list/list.component';
import {ItemComponent} from './item/item.component';

import {environment} from "../environments/environment";
import { PreviewComponent } from './preview/preview.component';

@NgModule({
    declarations: [
        AppComponent,
        TreeComponent,
        ListComponent,
        ItemComponent,
        PreviewComponent
    ],
    imports: [
        BrowserModule,
        HttpClientModule,
        RouterModule.forRoot([]),
        NoopAnimationsModule,
        MatButtonModule,
        MatToolbarModule,
        MatSidenavModule,
        MatTreeModule,
        MatIconModule,
        MatGridListModule,
        MatCheckboxModule,
        MatDialogModule,
        ApiModule.forRoot(apiConfig)
    ],
    entryComponents: [PreviewComponent],
    providers: [],
    bootstrap: [AppComponent]
})

export class AppModule {
}

export function apiConfig() {
    return new Configuration({
        basePath: environment.apiUrl,
    });
}