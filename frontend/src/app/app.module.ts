import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {AppComponent} from './app.component';
import {ApiModule, Configuration} from "../api";
import {TreeComponent} from './tree/tree.component';
import {ListComponent} from './list/list.component';
import {
    DxCheckBoxModule,
    DxPopupModule,
    DxResponsiveBoxModule,
    DxSelectBoxModule,
    DxTileViewModule,
    DxTreeViewModule
} from "devextreme-angular";
import {HttpClientModule} from "@angular/common/http";
import {environment} from "../environments/environment";
import { ItemComponent } from './item/item.component';

@NgModule({
    declarations: [
        AppComponent,
        TreeComponent,
        ListComponent,
        ItemComponent
    ],
    imports: [
        BrowserModule,
        DxTreeViewModule,
        DxResponsiveBoxModule,
        DxTileViewModule,
        DxSelectBoxModule,
        DxCheckBoxModule,
        HttpClientModule,
        DxPopupModule,
        ApiModule.forRoot(apiConfig)
    ],
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