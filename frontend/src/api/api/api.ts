export * from './directory.service';
import { DirectoryService } from './directory.service';
export * from './photo.service';
import { PhotoService } from './photo.service';
export const APIS = [DirectoryService, PhotoService];
