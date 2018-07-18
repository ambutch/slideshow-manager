export * from './command.service';
import { CommandService } from './command.service';
export * from './directory.service';
import { DirectoryService } from './directory.service';
export * from './photo.service';
import { PhotoService } from './photo.service';
export const APIS = [CommandService, DirectoryService, PhotoService];
