import { useQuery } from "@tanstack/react-query";
import type { OriginalTextResponse } from "../types/types";
import { getOriginaltexts } from "../api/originaltextapi";

function getOriginaltextlist() {
  const { data, error, isSuccess } = useQuery({
    queryKey: ["originaltexts"],
    queryFn: getOriginaltexts,
  });
  if (!isSuccess) {
    return <span>Loading...</span>;
  } else if (error) {
    return <span>Error when fetching texts...</span>;
  } else {
    return (
      <table>
        <tbody>
          {data.map((text: OriginalTextResponse) => (
            <tr key={text.id}>
              <td>{text.author_text}</td>
              <td>{text.title}</td>
              <td>{text.text_img}</td>
              <td>{text.insert_date}</td>
              <td>{text.hits}</td>
              <td>{text.place_id}</td>
              <td>{text.old_language_id}</td>
              <td>{text.author_id}</td>
            </tr>
          ))}
        </tbody>
      </table>
    );
  }
}
export default getOriginaltextlist;
