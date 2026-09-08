import { useQuery } from "@tanstack/react-query";
import { DataGrid, type GridColDef } from "@mui/x-data-grid";
import type { OriginalTextResponse } from "../types/types";
import { getOriginaltexts } from "../api/originaltextapi";

function getOriginaltextlist() {
  const { data, error, isSuccess } = useQuery({
    queryKey: ["originaltexts"],
    queryFn: getOriginaltexts,
  });
  const columns: GridColDef[] = [
    { field: "author_text", headerName: "Author Text", width: 200 },
    { field: "title", headerName: "Title", width: 200 },
    { field: "text_img", headerName: "Text Image", width: 200 },
    { field: "inser_date", headerName: "Insert Date", width: 150 },
    { field: "hits", headerName: "Hits", width: 150 },
    { field: "place_id", headerName: "Place Id", width: 150 },
    { field: "old_language_id", headerName: "Old Language Id", width: 150 },
    { field: "author_id", headerName: "Translation Author Id", width: 150 },
  ];
  if (!isSuccess) {
    return <span>Loading...</span>;
  } else if (error) {
    return <span>Error when fetching texts...</span>;
  } else {
    return (
      <DataGrid rows={data} columns={columns} getRowId={(row) => row.id} />
    );
  }
}
export default getOriginaltextlist;
